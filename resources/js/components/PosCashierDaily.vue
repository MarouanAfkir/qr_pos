<template>
  <div :dir="isRTL ? 'rtl' : 'ltr'">
    <!-- ===== Header (modernized) ===== -->
    <div class="pos-header pos-header--gradient">
      <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
          <div class="brand-wrap">
            <div class="logo-ring">
              <img :src="logoSrc" alt="Logo" />
            </div>
            <div class="brand-title">
              <h1>
                {{ restaurantName }}
                <span class="badge-pill ms-1 tag-soft">Report</span>
              </h1>
              <small>{{ tagline }}</small>
            </div>
          </div>

          <div class="header-tools">
            <div v-if="restaurantAddress" class="text-muted d-none d-md-block me-2">
              <i class="fa-solid fa-location-dot"></i>
              {{ restaurantAddress }}
            </div>

            <router-link class="btn-pill d-flex align-items-center gap-2" :to="{ name: 'pos' }" title="Open POS">
              <i class="fa-solid fa-cash-register"></i>
              <span>POS</span>
            </router-link>

            <div class="ms-2 d-flex align-items-center gap-2">
              <template v-if="isAuthed">
                <span class="btn-pill d-inline-flex align-items-center gap-2">
                  <i class="fa-solid fa-user-shield"></i>
                  <span class="text-truncate" style="max-width: 160px">
                    {{ authedUser?.name || authedUser?.email || 'Cashier' }}
                  </span>
                </span>
                <button class="btn btn-danger-soft btn-sm" @click="logout" :disabled="authLoading">
                  <i class="fa-solid fa-right-from-bracket me-1"></i>Logout
                </button>
              </template>
              <template v-else>
                <span class="text-muted small d-none d-md-inline">Not signed in</span>
              </template>
            </div>
          </div>
        </div>

        <!-- quick toolbar -->
        <div class="toolbar mt-2">
          <div class="toolbar-left">
            <div class="input-chip">
              <i class="fa-regular fa-calendar"></i>
              <input class="form-control form-control-sm date-input" type="date" v-model="dateStr" @change="reload" />
            </div>

            <div class="segmented" role="tablist" aria-label="Payment filter">
              <button
                class="seg-btn"
                :class="{ active: paymentFilter==='all' }"
                @click="setPaymentFilter('all')"
                role="tab"
              >All</button>
              <button
                class="seg-btn"
                :class="{ active: paymentFilter==='cash' }"
                @click="setPaymentFilter('cash')"
                role="tab"
              >Cash</button>
              <button
                class="seg-btn"
                :class="{ active: paymentFilter==='card' }"
                @click="setPaymentFilter('card')"
                role="tab"
              >Card</button>
              <button
                class="seg-btn"
                :class="{ active: paymentFilter==='other' }"
                @click="setPaymentFilter('other')"
                role="tab"
              >Other</button>
            </div>

            <div class="segmented" role="tablist" aria-label="Order type filter">
              <button class="seg-btn" :class="{ active: typeFilter==='all' }" @click="setTypeFilter('all')">All types</button>
              <button class="seg-btn" :class="{ active: typeFilter==='dinein' }" @click="setTypeFilter('dinein')">Dine-in</button>
              <button class="seg-btn" :class="{ active: typeFilter==='takeaway' }" @click="setTypeFilter('takeaway')">Takeaway</button>
              <button class="seg-btn" :class="{ active: typeFilter==='delivery' }" @click="setTypeFilter('delivery')">Delivery</button>
            </div>
          </div>

          <div class="toolbar-right">
            <div class="search-wrap">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input
                class="form-control form-control-sm search"
                v-model.trim="searchTerm"
                placeholder="Search ticket, code, payment…"
                @input="resetToFirstPage"
              />
            </div>

            <select class="form-select form-select-sm" v-model="sortBy" style="min-width: 160px" @change="resetToFirstPage">
              <option value="time_desc">Newest first</option>
              <option value="time_asc">Oldest first</option>
              <option value="total_desc">Total (high → low)</option>
              <option value="total_asc">Total (low → high)</option>
            </select>

            <div class="btn-group btn-group-sm density" role="group" aria-label="Density">
              <input type="radio" class="btn-check" id="denseOff" value="regular" v-model="density" />
              <label class="btn btn-outline-secondary" for="denseOff" title="Comfy rows">
                <i class="fa-regular fa-square"></i>
              </label>
              <input type="radio" class="btn-check" id="denseOn" value="compact" v-model="density" />
              <label class="btn btn-outline-secondary" for="denseOn" title="Compact rows">
                <i class="fa-solid fa-grip-lines"></i>
              </label>
            </div>

            <button class="btn btn-sub btn-sm" @click="reload" :disabled="loading">
              <i :class="loading ? 'fa-solid fa-spinner fa-spin' : 'fa-solid fa-rotate'"></i>
              <span class="ms-1 d-none d-sm-inline">Refresh</span>
            </button>
            <button class="btn btn-sub btn-sm" @click="exportCsv" :disabled="!orders.length">
              <i class="fa-solid fa-file-arrow-down me-1"></i>CSV
            </button>
            <button class="btn btn-sub btn-sm" @click="printTable" :disabled="!orders.length">
              <i class="fa-solid fa-print me-1"></i>Print
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== Body ===== -->
    <div class="container-fluid pos-shell" :aria-hidden="!isAuthed">
      <section class="panel" style="grid-column: 1 / -1">
        <!-- KPIs -->
        <div class="panel-head kpis">
          <div class="kpi-card">
            <div class="kpi-ico"><i class="fa-solid fa-receipt"></i></div>
            <div>
              <div class="kpi-label">Orders</div>
              <div class="kpi-value">{{ summary.count }}</div>
            </div>
          </div>
          <div class="kpi-card">
            <div class="kpi-ico"><i class="fa-solid fa-sack-dollar"></i></div>
            <div>
              <div class="kpi-label">Total (All)</div>
              <div class="kpi-value">{{ money(summary.total) }}</div>
            </div>
          </div>
          <div class="kpi-card">
            <div class="kpi-ico"><i class="fa-solid fa-money-bill-wave"></i></div>
            <div>
              <div class="kpi-label">Cash</div>
              <div class="kpi-value">{{ money(summary.by_method.cash || 0) }}</div>
            </div>
          </div>
          <div class="kpi-card">
            <div class="kpi-ico"><i class="fa-solid fa-credit-card"></i></div>
            <div>
              <div class="kpi-label">Card</div>
              <div class="kpi-value">{{ money(summary.by_method.card || 0) }}</div>
            </div>
          </div>
          <div class="kpi-card">
            <div class="kpi-ico"><i class="fa-solid fa-wallet"></i></div>
            <div>
              <div class="kpi-label">Other</div>
              <div class="kpi-value">{{ money(summary.by_method.other || 0) }}</div>
            </div>
          </div>
          <div class="date-chip">
            <i class="fa-regular fa-calendar"></i>
            <span>{{ localDateLabel }}</span>
          </div>
        </div>

        <div class="panel-body">
          <!-- Loading skeleton -->
          <div v-if="loading">
            <div class="skeleton-kpis mb-2"></div>
            <div class="table-skeleton">
              <div v-for="i in 6" :key="'sk' + i" class="row-skeleton"></div>
            </div>
          </div>

          <!-- Orders table -->
          <div v-else>
            <div class="table-responsive modern-table" :class="{ compact: density==='compact' }">
              <table class="table table-sm align-middle">
                <thead>
                  <tr>
                    <th style="width:140px">Time</th>
                    <th style="width:90px">Ticket</th>
                    <th>Order Ref</th>
                    <th style="width:120px" class="text-end">Total</th>
                    <th style="width:230px">Payments</th>
                    <th style="width:120px">Type</th>
                    <th style="width:80px">Table</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="o in pagedOrders" :key="o.id">
                    <td>
                      <span class="time-pill"><i class="fa-regular fa-clock me-1"></i>{{ fmtTime(o.created_at) }}</span>
                    </td>
                    <td>
                      <span class="badge-pill" style="background:#fff;border:1px dashed var(--line)">{{ o.daily_order || '—' }}</span>
                    </td>
                    <td class="text-truncate">
                      <div class="ref-cell">
                        <span class="ref">{{ o.order_code || o.id }}</span>
                        <span v-if="o.id" class="muted small">#{{ o.id }}</span>
                      </div>
                    </td>
                    <td class="text-end fw-bold">{{ money(o.total || 0) }}</td>
                    <td>
                      <div class="d-flex flex-wrap gap-1">
                        <span
                          v-for="(p, i) in o.payments || []"
                          :key="o.id + '-p' + i"
                          class="badge-pill"
                          :style="pillStyle(p.method)"
                          :title="`Amount: ${money(p.amount || 0)}`"
                        >
                          {{ (p.method || 'other').toUpperCase() }}: {{ money(p.amount || 0) }}
                        </span>
                        <span v-if="!(o.payments && o.payments.length) && o.payment_method"
                              class="badge-pill"
                              :style="pillStyle(o.payment_method)">
                          {{ o.payment_method.toUpperCase() }}: {{ money(o.total || 0) }}
                        </span>
                      </div>
                    </td>
                    <td class="text-uppercase">
                      <span class="chip" :class="'ot-' + (o.order_type || 'na')">{{ (o.order_type || '').toString() || '—' }}</span>
                    </td>
                    <td>{{ o.table_number || '—' }}</td>
                  </tr>

                  <tr v-if="!filteredSortedOrders.length">
                    <td colspan="7">
                      <div class="empty">
                        <div class="emoji">🧾</div>
                        <div class="title">Nothing to show</div>
                        <div class="subtitle">Try another date or clear filters.</div>
                      </div>
                    </td>
                  </tr>
                </tbody>
                <tfoot v-if="filteredSortedOrders.length">
                  <tr>
                    <th colspan="3" class="text-end">Totals:</th>
                    <th class="text-end">{{ money(summaryFiltered.total) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div>

            <!-- Pagination -->
            <div v-if="filteredSortedOrders.length" class="pager">
              <div class="muted small">
                Showing {{ pageStart + 1 }}–{{ pageEnd }} of {{ filteredSortedOrders.length }}
              </div>
              <div class="d-flex align-items-center gap-2">
                <select class="form-select form-select-sm w-auto" v-model.number="perPage" @change="resetToFirstPage">
                  <option :value="10">10 / page</option>
                  <option :value="20">20 / page</option>
                  <option :value="50">50 / page</option>
                </select>
                <div class="btn-group btn-group-sm" role="group" aria-label="Pagination">
                  <button class="btn btn-sub" :disabled="page===1" @click="page=1"><i class="fa-solid fa-angles-left"></i></button>
                  <button class="btn btn-sub" :disabled="page===1" @click="page--"><i class="fa-solid fa-angle-left"></i></button>
                  <span class="px-2 fw-bold">{{ page }}</span>
                  <button class="btn btn-sub" :disabled="page===maxPage" @click="page++"><i class="fa-solid fa-angle-right"></i></button>
                  <button class="btn btn-sub" :disabled="page===maxPage" @click="page=maxPage"><i class="fa-solid fa-angles-right"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sticky summary footer -->
        <div class="summary-footer" v-if="filteredSortedOrders.length">
          <div class="sum-item">
            <span class="lbl">Orders</span>
            <span class="val">{{ filteredSortedOrders.length }}</span>
          </div>
          <div class="sum-item">
            <span class="lbl">Total</span>
            <span class="val">{{ money(summaryFiltered.total) }}</span>
          </div>
          <div class="sum-item">
            <span class="lbl">Cash</span>
            <span class="val">{{ money(summaryFiltered.by_method.cash || 0) }}</span>
          </div>
          <div class="sum-item">
            <span class="lbl">Card</span>
            <span class="val">{{ money(summaryFiltered.by_method.card || 0) }}</span>
          </div>
          <div class="sum-item">
            <span class="lbl">Other</span>
            <span class="val">{{ money(summaryFiltered.by_method.other || 0) }}</span>
          </div>
          <div class="sum-actions">
            <button class="btn btn-sub btn-sm" @click="exportCsv"><i class="fa-solid fa-file-arrow-down me-1"></i>CSV</button>
            <button class="btn btn-main btn-sm" @click="printTable"><i class="fa-solid fa-print me-1"></i>Print</button>
          </div>
        </div>
      </section>
    </div>

    <!-- Toast host -->
    <div id="toast" class="toast-pos" aria-live="polite" aria-atomic="true"></div>
  </div>
</template>

<script>
export default {
  name: "PosCashierDaily",
  props: {
    restaurant: { type: Object, default: () => ({}) },
    defaultLanguage: { type: String, default: "en" },
    currency: { type: String, default: " DH" },
    logoFallback: { type: String, default: "/assets/img/logo/logo.svg" },
    meEndpoint: { type: String, default: "/api/pos/me" },
    ordersTodayEndpoint: { type: String, default: "/api/pos/orders/today" },
  },
  data() {
    return {
      orders: [],
      summary: { count: 0, total: 0, by_method: { cash: 0, card: 0, other: 0 } },
      loading: false,

      language: this.defaultLanguage || "en",
      authedUser: null,
      authToken: localStorage.getItem("pos_token") || null,
      authLoading: false,

      numberFmt: null,
      dateStr: this.todayStr(),

      // UI/UX additions
      searchTerm: "",
      paymentFilter: "all",       // all | cash | card | other
      typeFilter: "all",          // all | dinein | takeaway | delivery
      sortBy: "time_desc",        // time_desc | time_asc | total_desc | total_asc
      density: "regular",         // regular | compact
      page: 1,
      perPage: 10,
    };
  },
  computed: {
    isAuthed() { return !!this.authedUser; },
    isRTL() {
      const code = (this.language || "").toLowerCase();
      return ["ar", "he", "fa", "ur"].includes(code);
    },
    restaurantName() { return this.restaurant?.name || "Restaurant"; },
    logoSrc() { return this.restaurant?.logo || this.logoFallback; },
    restaurantAddress() { return this.restaurant?.address || ""; },
    tagline() {
      return (this.restaurant?.settings && this.restaurant.settings.tagline) || "Fresh • Local • Delicious";
    },
    localDateLabel() {
      try {
        const d = new Date(this.dateStr + "T00:00:00");
        return d.toLocaleDateString(undefined, { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
      } catch(_) { return this.dateStr; }
    },

    // Filter + search + sort
    filteredSortedOrders() {
      let list = this.orders.slice();

      // Payment filter
      if (this.paymentFilter !== 'all') {
        const m = this.paymentFilter;
        list = list.filter(o => {
          const pays = Array.isArray(o.payments) && o.payments.length
            ? o.payments
            : (o.payment_method ? [{ method: o.payment_method, amount: o.total || 0 }] : []);
          return pays.some(p => (p.method || 'other').toLowerCase() === m);
        });
      }

      // Order type filter
      if (this.typeFilter !== 'all') {
        list = list.filter(o => (o.order_type || '').toString().toLowerCase() === this.typeFilter);
      }

      // Search
      if (this.searchTerm) {
        const q = this.searchTerm.toLowerCase();
        list = list.filter(o => {
          const ref = String(o.order_code || o.id || '').toLowerCase();
          const ticket = String(o.daily_order || '').toLowerCase();
          const type = String(o.order_type || '').toLowerCase();
          const methods = (o.payments || []).map(p => String(p.method || '').toLowerCase()).join(' ');
          return ref.includes(q) || ticket.includes(q) || type.includes(q) || methods.includes(q);
        });
      }

      // Sort
      const sort = this.sortBy;
      list.sort((a, b) => {
        if (sort === 'time_desc') return new Date(b.created_at) - new Date(a.created_at);
        if (sort === 'time_asc')  return new Date(a.created_at) - new Date(b.created_at);
        if (sort === 'total_desc') return (b.total || 0) - (a.total || 0);
        if (sort === 'total_asc')  return (a.total || 0) - (b.total || 0);
        return 0;
      });

      return list;
    },

    // Pagination
    maxPage() {
      return Math.max(1, Math.ceil(this.filteredSortedOrders.length / this.perPage));
    },
    pageStart() {
      return (this.page - 1) * this.perPage;
    },
    pageEnd() {
      return Math.min(this.filteredSortedOrders.length, this.page * this.perPage);
    },
    pagedOrders() {
      return this.filteredSortedOrders.slice(this.pageStart, this.pageEnd);
    },

    // Summary for current filtered set
    summaryFiltered() {
      return this.buildSummaryFallback(this.filteredSortedOrders);
    },
  },
  watch: {
    paymentFilter() { this.resetToFirstPage(); },
    typeFilter() { this.resetToFirstPage(); },
    sortBy() { this.resetToFirstPage(); },
    perPage() { this.resetToFirstPage(); },
  },
  mounted() {
    const iso = this.isoCurrency();
    try {
      this.numberFmt = iso ? new Intl.NumberFormat(this.isRTL ? "ar" : this.language || "en", {
        style: "currency",
        currency: iso,
        currencyDisplay: "symbol",
        minimumFractionDigits: 2,
      }) : null;
    } catch(_) { this.numberFmt = null; }

    this.initAuth().then(() => this.reload());
  },
  methods: {
    // ===== util =====
    isoCurrency() {
      const raw = (this.currency || "").trim().toUpperCase();
      if (raw === "DH" || raw === "MAD") return "MAD";
      if (/^[A-Z]{3}$/.test(raw)) return raw;
      return null;
    },
    money(n) {
      const v = Number(n || 0);
      try { if (this.numberFmt) return this.numberFmt.format(v); } catch(_) {}
      return v.toFixed(2) + this.currency;
    },
    fmtTime(iso) {
      try {
        return new Date(iso).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      } catch(_) { return '—'; }
    },
    pillStyle(method) {
      const m = (method || 'other').toString().toLowerCase();
      if (m === 'cash')  return "background:#ecfdf5;border:1px solid #bbf7d0;color:#065f46";
      if (m === 'card')  return "background:#eff6ff;border:1px solid #bfdbfe;color:#1e40af";
      return "background:#fff7ed;border:1px solid #fed7aa;color:#9a3412";
    },
    toast(html) {
      const host = document.getElementById("toast");
      if (!host) return;
      const el = document.createElement("div");
      el.className = "toast";
      el.innerHTML = html;
      host.appendChild(el);
      setTimeout(() => el.remove(), 2600);
    },
    todayStr() {
      const d = new Date();
      const y = d.getFullYear();
      const m = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      return `${y}-${m}-${day}`;
    },
    setPaymentFilter(v) { this.paymentFilter = v; },
    setTypeFilter(v) { this.typeFilter = v; },
    resetToFirstPage() { this.page = 1; },

    // ===== auth =====
    authHeaders() {
      return this.authToken ? { Authorization: "Bearer " + this.authToken } : {};
    },
    async fetchMe() {
      if (!this.authToken) return null;
      try {
        const res = await fetch(this.meEndpoint, { headers: { Accept: "application/json", ...this.authHeaders() } });
        if (res.status === 401) {
          this.authToken = null;
          localStorage.removeItem("pos_token");
          return null;
        }
        if (!res.ok) return null;
        return await res.json();
      } catch (_) { return null; }
    },
    async initAuth() {
      const me = await this.fetchMe();
      this.authedUser = me || null;
    },
    async logout() {
      this.authLoading = true;
      try {
        localStorage.removeItem("pos_token");
      } finally {
        this.authedUser = null;
        this.authLoading = false;
      }
    },

    // ===== data =====
    async reload() {
      this.loading = true;
      try {
        const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || 'UTC';
        const url = new URL(this.ordersTodayEndpoint, window.location.origin);
        url.searchParams.set('date', this.dateStr);
        url.searchParams.set('tz', tz);

        const res = await fetch(url.toString(), {
          headers: { Accept: "application/json", ...this.authHeaders() },
        });
        if (res.status === 401) {
          this.authedUser = null;
          this.toast("Please sign in again.");
          return;
        }
        if (!res.ok) throw new Error(`Failed to load (${res.status})`);
        const j = await res.json();

        this.orders = Array.isArray(j.orders) ? j.orders : [];
        this.summary = j.summary || this.buildSummaryFallback(this.orders);
        this.resetToFirstPage();
      } catch (e) {
        this.toast("Could not load orders.");
      } finally {
        this.loading = false;
      }
    },

    buildSummaryFallback(list) {
      const s = { count: 0, total: 0, by_method: { cash: 0, card: 0, other: 0 } };
      s.count = list.length;
      s.total = list.reduce((a, o) => a + Number(o.total || 0), 0);
      list.forEach(o => {
        const pays = Array.isArray(o.payments) && o.payments.length
          ? o.payments
          : (o.payment_method ? [{ method: o.payment_method, amount: o.total || 0 }] : []);
        pays.forEach(p => {
          const m = (p.method || 'other').toLowerCase();
          s.by_method[m] = (s.by_method[m] || 0) + Number(p.amount || 0);
        });
      });
      s.total = Number(s.total.toFixed(2));
      Object.keys(s.by_method).forEach(k => s.by_method[k] = Number((s.by_method[k] || 0).toFixed(2)));
      return s;
    },

    // ===== print & export =====
    printTable() {
      window.print();
    },
    exportCsv() {
      if (!this.filteredSortedOrders.length) return;
      const rows = [
        ["Time", "Ticket", "OrderRef", "Total", "Payments", "OrderType", "Table"]
      ];
      this.filteredSortedOrders.forEach(o => {
        const pays = Array.isArray(o.payments) && o.payments.length
          ? o.payments.map(p => `${(p.method || 'other').toUpperCase()}:${(p.amount || 0)}`).join(" | ")
          : (o.payment_method ? `${String(o.payment_method).toUpperCase()}:${o.total || 0}` : "");
        rows.push([
          this.fmtTime(o.created_at),
          o.daily_order || "",
          o.order_code || o.id,
          (o.total || 0),
          pays,
          (o.order_type || "").toString(),
          (o.table_number || "")
        ]);
      });
      const csv = rows.map(r => r.map(v => `"${String(v).replaceAll('"','""')}"`).join(",")).join("\n");
      const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
      const url = URL.createObjectURL(blob);
      const a = document.createElement("a");
      a.href = url;
      a.download = `cashier_report_${this.dateStr}.csv`;
      a.click();
      URL.revokeObjectURL(url);
    },
  },
};
</script>

<style scoped>
/* --- header polish --- */
.pos-header--gradient {
  background: linear-gradient(135deg, var(--pearl) 0%, var(--mint) 100%);
}
.tag-soft {
  background:#fff;border:1px solid #e4f4ea;font-size:.7rem;
}

.toolbar {
  display:flex; align-items:center; justify-content:space-between; gap:.6rem;
  padding:.4rem 0 .2rem;
}
.toolbar-left, .toolbar-right {
  display:flex; align-items:center; gap:.5rem; flex-wrap:wrap;
}
.search-wrap {
  position:relative; min-width: 220px;
}
.search-wrap i {
  position:absolute; inset-inline-start:10px; top:50%; transform:translateY(-50%); opacity:.6;
}
.search-wrap .search {
  padding-inline-start: 30px;
}
.input-chip {
  display:flex; align-items:center; gap:.4rem;
  border:1px solid #e4f4ea; background:#fff; border-radius:.7rem; padding:.2rem .45rem;
}
.input-chip .date-input {
  border:none; outline:none; box-shadow:none; padding:.2rem .2rem; background:transparent;
}

/* segmented control */
.segmented {
  display:inline-flex; background:#fff; border:1px solid #e4f4ea; border-radius:.7rem; overflow:hidden;
}
.seg-btn {
  padding:.35rem .6rem; border:none; background:transparent; font-weight:700;
}
.seg-btn + .seg-btn { border-inline-start:1px solid #eaf4ee; }
.seg-btn.active { background:#eaf6ef; color:#065f46; }

/* KPI row */
.kpis {
  display:flex; flex-wrap:wrap; align-items:center; gap:.6rem; justify-content:space-between;
}
.kpi-card {
  display:flex; align-items:center; gap:.6rem;
  background:#fff; border:1px solid var(--line); border-radius:.8rem; padding:.65rem .8rem;
  min-width: 180px;
}
.kpi-ico {
  width:36px; height:36px; display:grid; place-items:center; border-radius:10px; background:#f2fbf5; border:1px solid #d8efe0; color:var(--brand-600);
}
.kpi-label { color: var(--muted); font-size:.85rem; }
.kpi-value { font-weight:800; font-size:1.15rem; }
.date-chip {
  display:flex; align-items:center; gap:.45rem; padding:.4rem .7rem; border-radius:999px;
  background:#fff; border:1px dashed var(--line); color:var(--ink);
}

/* table polish */
.modern-table table thead th {
  position:sticky; top:0; background:var(--card); z-index:2; border-bottom:1px solid var(--line);
}
.modern-table table tbody tr:hover {
  background: linear-gradient(0deg, #ffffff 0%, #f6faf7 100%);
}
.modern-table.compact table td, .modern-table.compact table th {
  padding-top:.35rem; padding-bottom:.35rem;
}
.ref-cell { display:flex; flex-direction:column; }
.ref-cell .ref { font-weight:700; }
.ref-cell .muted { color:var(--muted); }
.time-pill {
  background:#fff; border:1px solid #e4f4ea; border-radius:999px; padding:.1rem .45rem; font-size:.85rem;
}

/* order type chips */
.chip {
  display:inline-flex; align-items:center; gap:.35rem;
  padding:.1rem .5rem; border-radius:999px; border:1px solid #e4f4ea; background:#fff; font-weight:700; font-size:.85rem;
}
.chip.ot-dinein { background:#eef9f3; border-color:#cde8d5; color:#065f46; }
.chip.ot-takeaway { background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
.chip.ot-delivery { background:#eff6ff; border-color:#bfdbfe; color:#1e40af; }

/* empty state */
.empty {
  text-align:center; padding:2.2rem .5rem;
}
.empty .emoji { font-size:2rem; }
.empty .title { font-weight:800; margin-top:.4rem; }
.empty .subtitle { color:var(--muted); }

/* pager */
.pager {
  display:flex; align-items:center; justify-content:space-between; gap:.6rem; margin-top:.6rem;
}
.muted { color: var(--muted); }

/* sticky summary footer */
.summary-footer {
  position: sticky; bottom: 0; background: linear-gradient(180deg, rgba(255,255,255,.65), #fff);
  border-top:1px solid var(--line);
  display:flex; align-items:center; justify-content:space-between; gap:.6rem;
  padding:.5rem .8rem; backdrop-filter: blur(6px);
}
.summary-footer .sum-item { display:flex; flex-direction:column; gap:.15rem; min-width: 90px; }
.summary-footer .lbl { color:var(--muted); font-size:.8rem; }
.summary-footer .val { font-weight:800; }

/* loading skeletons */
.skeleton-kpis {
  height: 64px; border-radius:.8rem;
  background: linear-gradient(90deg,#f1f5f9 25%,#ffffff 50%,#f1f5f9 75%); background-size: 200% 100%;
  animation: shimmer 1.2s infinite linear;
}
.table-skeleton .row-skeleton {
  height: 44px; margin:.35rem 0; border-radius:.5rem;
  background: linear-gradient(90deg,#f1f5f9 25%,#ffffff 50%,#f1f5f9 75%); background-size: 200% 100%;
  animation: shimmer 1.2s infinite linear;
}
@keyframes shimmer { to { background-position: 200% 0; } }

/* buttons group compact */
.density .btn { padding:.25rem .45rem; }
</style>
