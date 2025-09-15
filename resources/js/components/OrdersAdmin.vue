<template>
    <div class="bo-card" :class="{ 'is-compact': density === 'compact' }">
        <!-- ===== Barre supérieure (sobre) ===== -->
        <div class="topbar">
            <div class="topbar-left">
                <div class="brand">
                    <div class="brand-mark">
                        <i class="fa-solid fa-cash-register"></i>
                    </div>
                    <div>
                        <div class="brand-line">POS Admin</div>
                        <div class="crumbs">
                            <span>Accueil</span>
                            <i class="fa-solid fa-chevron-right mx-1"></i>
                            <span>Back-office</span>
                            <i class="fa-solid fa-chevron-right mx-1"></i>
                            <strong class="text-primary">{{
                                activeTabLabel
                            }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="topbar-center">
                <div class="segmented">
                    <button
                        class="seg-btn"
                        :class="{ active: activeTab === 'orders' }"
                        @click="setTab('orders')"
                    >
                        <i class="fa-solid fa-clipboard-list me-1"></i>
                        Commandes
                        <span
                            class="seg-dot"
                            v-if="activeTab === 'orders'"
                        ></span>
                    </button>
                    <button
                        class="seg-btn"
                        :class="{ active: activeTab === 'reports' }"
                        @click="setTab('reports')"
                    >
                        <i class="fa-solid fa-chart-simple me-1"></i>
                        Rapports
                        <span
                            class="seg-dot"
                            v-if="activeTab === 'reports'"
                        ></span>
                    </button>
                    <button
                        class="seg-btn"
                        :class="{ active: activeTab === 'dashboard' }"
                        @click="setTab('dashboard')"
                    >
                        <i class="fa-solid fa-gauge-high me-1"></i>
                        Tableau de bord
                        <span
                            class="seg-dot"
                            v-if="activeTab === 'dashboard'"
                        ></span>
                    </button>
                </div>
            </div>

            <div class="topbar-right">
                <!-- Densité -->
                <div class="density-wrap d-none d-md-flex">
                    <span class="text-muted small me-1">Densité</span>
                    <div class="segmented small">
                        <button
                            class="seg-btn"
                            :class="{ active: density === 'cozy' }"
                            @click="density = 'cozy'"
                        >
                            <i class="fa-solid fa-grip-lines"></i>
                        </button>
                        <button
                            class="seg-btn"
                            :class="{ active: density === 'compact' }"
                            @click="density = 'compact'"
                        >
                            <i class="fa-solid fa-grip-lines-vertical"></i>
                        </button>
                    </div>
                </div>

                <template v-if="activeTab === 'orders'">
                    <span class="pill">Résultats : {{ total }}</span>
                    <button
                        class="btn-main"
                        @click="reload"
                        :disabled="loading"
                    >
                        <i class="fa-solid fa-rotate me-1"></i>Actualiser
                    </button>
                </template>

                <template v-else-if="activeTab === 'reports'">
                    <button
                        class="btn btn-quiet"
                        @click="printReport"
                        :disabled="reports.loading || !reports.rows.length"
                    >
                        <i class="fa-solid fa-print me-1"></i>Imprimer
                    </button>
                    <button
                        class="btn-main"
                        @click="exportReport"
                        :disabled="reports.loading || !reports.rows.length"
                    >
                        <i class="fa-solid fa-file-arrow-down me-1"></i>Exporter
                        CSV
                    </button>
                </template>

                <template v-else-if="activeTab === 'dashboard'">
                    <button
                        class="btn-main"
                        @click="fetchDashboard"
                        :disabled="dashboard.loading"
                    >
                        <i class="fa-solid fa-rotate me-1"></i>Actualiser
                    </button>
                </template>

                <!-- User / Logout -->
                <div class="vr d-none d-md-inline mx-1"></div>
                <div
                    class="user-controls d-flex align-items-center gap-2"
                    v-if="currentUser"
                >
                    <span
                        class="small text-muted me-1 text-truncate"
                        :title="currentUser.name || currentUser.email"
                        style="max-width: 160px; display: inline-block"
                    >
                        {{ currentUser.name || currentUser.email }}
                    </span>
                    <button
                        class="btn btn-quiet"
                        @click="logout"
                        :disabled="loggingOut"
                    >
                        <i class="fa-solid fa-right-from-bracket me-1"></i
                        >Déconnexion
                    </button>
                </div>
            </div>
        </div>

        <!-- ===== ONGLET COMMANDES ===== -->
        <div v-show="activeTab === 'orders'" class="bo-body">
            <!-- Filtres (barre collante) -->
            <div class="bo-card mb-3 tools-sticky quiet-surface">
                <div class="bo-body">
                    <!-- Raccourcis + Mes commandes -->
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="text-muted small">Plage rapide :</span>
                        <button
                            class="btn btn-chip"
                            @click="setRange('today')"
                            :disabled="loading"
                        >
                            Aujourd’hui
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRange('yesterday')"
                            :disabled="loading"
                        >
                            Hier
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRange('week')"
                            :disabled="loading"
                        >
                            Cette semaine
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRange('month')"
                            :disabled="loading"
                        >
                            Ce mois
                        </button>
                        <div class="vr d-none d-md-inline mx-1"></div>
                        <label
                            class="small d-flex align-items-center gap-1"
                            v-if="currentUser"
                        >
                            <input
                                type="checkbox"
                                v-model="filters.only_mine"
                                @change="syncMine()"
                            />
                            Uniquement mes commandes
                        </label>
                    </div>

                    <!-- Grille des filtres -->
                    <div class="search-row">
                        <div class="input-wrap">
                            <i
                                class="fa-solid fa-magnifying-glass input-icon"
                            ></i>
                            <input
                                v-model.trim="filters.q"
                                type="search"
                                class="form-control"
                                placeholder="Rechercher code, client, notes…"
                                @keyup.enter="applyFilters"
                            />
                        </div>

                        <select
                            v-model="filters.order_type"
                            class="form-select"
                        >
                            <option value="">Tous les types</option>
                            <option value="dinein">Sur place</option>
                            <option value="takeaway">À emporter</option>
                            <option value="delivery">Livraison</option>
                        </select>

                        <select v-model="filters.status" class="form-select">
                            <option value="">Tous les statuts</option>
                            <option value="paid">Payé</option>
                            <option value="pending">En attente</option>
                            <option value="void">Annulé</option>
                            <option value="refunded">Remboursé</option>
                        </select>

                        <select
                            v-model="filters.cashier_id"
                            class="form-select"
                            :disabled="filters.only_mine"
                        >
                            <option value="">Tous les caissiers</option>
                            <option
                                v-for="c in cashiers"
                                :key="c.id"
                                :value="String(c.id)"
                            >
                                {{ c.name || c.email || "#" + c.id }}
                            </option>
                        </select>

                        <div class="input-wrap">
                            <i class="fa-regular fa-calendar input-icon"></i>
                            <input
                                v-model="filters.from"
                                type="date"
                                class="form-control"
                            />
                        </div>
                        <div class="input-wrap">
                            <i class="fa-regular fa-calendar input-icon"></i>
                            <input
                                v-model="filters.to"
                                type="date"
                                class="form-control"
                            />
                        </div>

                        <select
                            v-model.number="perPage"
                            class="form-select small-w"
                        >
                            <option :value="15">15</option>
                            <option :value="25">25</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>

                        <button
                            class="btn-main"
                            @click="applyFilters"
                            :disabled="loading"
                        >
                            <i class="fa-solid fa-filter me-1"></i>Appliquer
                        </button>
                        <button
                            class="btn btn-quiet"
                            @click="resetFilters"
                            :disabled="loading"
                        >
                            Effacer
                        </button>
                    </div>

                    <!-- Filtres actifs -->
                    <div v-if="activeChips.length" class="active-chips">
                        <span class="text-muted small me-2">Actifs :</span>
                        <span
                            class="chip"
                            v-for="(c, i) in activeChips"
                            :key="i"
                            >{{ c }}</span
                        >
                        <button
                            class="btn-link small ms-2"
                            @click="resetFilters"
                        >
                            Tout réinitialiser
                        </button>
                    </div>
                </div>
            </div>

            <!-- Disposition 2 colonnes -->
            <div class="content-grid">
                <!-- Table -->
                <div class="content-main">
                    <div class="table-responsive soft-shadow">
                        <table class="table align-middle pro-table">
                            <thead>
                                <tr class="text-muted">
                                    <th class="sticky-th">Date</th>
                                    <th class="sticky-th">Ticket</th>
                                    <th class="sticky-th">Code</th>
                                    <th class="sticky-th">Type</th>
                                    <th class="sticky-th">Table</th>
                                    <th class="sticky-th text-end">
                                        Sous-total
                                    </th>
                                    <th class="sticky-th text-end">Remise</th>
                                    <th class="sticky-th text-end">Total</th>
                                    <th class="sticky-th">Statut</th>
                                    <th class="sticky-th">Paiements</th>
                                    <th class="sticky-th">Caissier</th>
                                    <th class="sticky-th text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="!loading && !orders.length">
                                    <td
                                        colspan="12"
                                        class="text-center text-muted py-4"
                                    >
                                        Aucune commande trouvée.
                                    </td>
                                </tr>

                                <tr
                                    v-for="o in orders"
                                    :key="o.id"
                                    class="row-hover"
                                >
                                    <td>{{ fmtDate(o.created_at) }}</td>
                                    <td>
                                        <span
                                            v-if="dailyNum(o) != null"
                                            class="badge badge-ticket"
                                            >#{{ dailyNum(o) }}</span
                                        >
                                        <span v-else class="text-muted">—</span>
                                    </td>
                                    <td class="fw-bold">
                                        {{
                                            o.order_code || o.code || "#" + o.id
                                        }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-soft text-uppercase"
                                            >{{ o.order_type }}</span
                                        >
                                    </td>
                                    <td>{{ o.table_number || "—" }}</td>
                                    <td class="text-end">
                                        {{ money(safeNum(o.subtotal)) }}
                                    </td>
                                    <td class="text-end">
                                        {{ money(safeNum(o.discount_amount)) }}
                                    </td>
                                    <td class="text-end fw-bold">
                                        {{ money(safeNum(o.total)) }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-soft text-uppercase"
                                        >
                                            {{ o.status || "paid" }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            v-if="payments(o).length"
                                            class="text-muted small"
                                        >
                                            {{
                                                payments(o)
                                                    .map(
                                                        (p) =>
                                                            p.method?.toUpperCase() ||
                                                            "—"
                                                    )
                                                    .join(", ")
                                            }}
                                        </span>
                                        <span v-else class="text-muted small"
                                            >—</span
                                        >
                                    </td>
                                    <td
                                        class="text-truncate"
                                        :title="cashierName(o) || '—'"
                                    >
                                        <span class="small">{{
                                            cashierName(o) || "—"
                                        }}</span>
                                    </td>
                                    <td class="text-end row-actions">
                                        <div class="btn-group">
                                            <button
                                                class="btn btn-sm btn-ghost"
                                                @click="openDetails(o)"
                                            >
                                                <i
                                                    class="fa-regular fa-eye"
                                                ></i>
                                            </button>
                                            <button
                                                class="btn btn-sm btn-ghost"
                                                @click="printOrder(o)"
                                            >
                                                <i
                                                    class="fa-solid fa-print"
                                                ></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        class="d-flex align-items-center justify-content-between mt-2"
                    >
                        <div class="text-muted small">
                            Page {{ page }} / {{ lastPage }} • Affichage de
                            {{ orders.length }} sur {{ total }}
                        </div>
                        <div class="d-flex gap-1">
                            <button
                                class="btn btn-quiet btn-sm"
                                :disabled="page <= 1 || loading"
                                @click="go(page - 1)"
                            >
                                ‹ Préc.
                            </button>
                            <button
                                class="btn btn-quiet btn-sm"
                                :disabled="page >= lastPage || loading"
                                @click="go(page + 1)"
                            >
                                Suiv. ›
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rail droit -->
                <aside class="side-rail">
                    <div class="stat">
                        <div class="text-muted small">
                            Chiffre d’affaires (cette page)
                        </div>
                        <h4 class="mb-0">{{ money(pageTotals.total) }}</h4>
                        <div class="small text-muted">
                            Panier moyen : {{ money(avgTicket) }}
                        </div>
                    </div>
                    <div class="stat">
                        <div class="text-muted small">
                            Caissier (cette page)
                        </div>
                        <h4
                            class="text-truncate mb-0"
                            :title="pageCashierSummary || '—'"
                        >
                            {{ pageCashierSummary || "—" }}
                        </h4>
                    </div>
                    <div class="bo-card">
                        <div class="bo-head small">
                            <strong>Moyens de paiement</strong>
                        </div>
                        <div class="bo-body">
                            <div
                                v-if="pagePaymentBreakdown.length"
                                class="barlist"
                            >
                                <div
                                    v-for="p in pagePaymentBreakdown"
                                    :key="p.method"
                                    class="barlist-row"
                                >
                                    <div class="barlist-label text-uppercase">
                                        {{ p.method }}
                                    </div>
                                    <div class="barlist-bar">
                                        <div
                                            class="barlist-fill"
                                            :style="{ width: p.pct + '%' }"
                                        ></div>
                                    </div>
                                    <div class="barlist-value">
                                        {{ money(p.total) }}
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-muted small">
                                Aucune donnée
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- ===== ONGLET RAPPORTS ===== -->
        <div v-show="activeTab === 'reports'" class="bo-body">
            <div class="bo-card mb-3 quiet-surface tools-sticky">
                <div class="bo-body">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="text-muted small">Plage rapide :</span>
                        <button
                            class="btn btn-chip"
                            @click="setRangeFor('reports', 'today')"
                            :disabled="reports.loading"
                        >
                            Aujourd’hui
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRangeFor('reports', 'yesterday')"
                            :disabled="reports.loading"
                        >
                            Hier
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRangeFor('reports', 'week')"
                            :disabled="reports.loading"
                        >
                            Cette semaine
                        </button>
                        <button
                            class="btn btn-chip"
                            @click="setRangeFor('reports', 'month')"
                            :disabled="reports.loading"
                        >
                            Ce mois
                        </button>
                        <div class="vr d-none d-md-inline mx-1"></div>
                        <label class="small d-flex align-items-center gap-2">
                            Regrouper par
                            <select
                                class="form-select form-select-sm w-auto"
                                v-model="reports.groupBy"
                                :disabled="reports.loading"
                            >
                                <option value="day">Jour</option>
                                <option value="hour">Heure</option>
                                <option value="cashier">Caissier</option>
                                <option value="order_type">
                                    Type de commande
                                </option>
                                <option value="payment_method">
                                    Moyen de paiement
                                </option>
                                <option value="status">Statut</option>
                            </select>
                        </label>
                    </div>

                    <div class="search-row">
                        <div class="input-wrap">
                            <i
                                class="fa-solid fa-magnifying-glass input-icon"
                            ></i>
                            <input
                                v-model.trim="reports.q"
                                type="search"
                                class="form-control"
                                placeholder="Rechercher dans les commandes (optionnel)"
                                @keyup.enter="runReport"
                                :disabled="reports.loading"
                            />
                        </div>

                        <select
                            v-model="reports.order_type"
                            class="form-select"
                            :disabled="reports.loading"
                        >
                            <option value="">Tous les types</option>
                            <option value="dinein">Sur place</option>
                            <option value="takeaway">À emporter</option>
                            <option value="delivery">Livraison</option>
                        </select>

                        <select
                            v-model="reports.status"
                            class="form-select"
                            :disabled="reports.loading"
                        >
                            <option value="">Tous les statuts</option>
                            <option value="paid">Payé</option>
                            <option value="pending">En attente</option>
                            <option value="void">Annulé</option>
                            <option value="refunded">Remboursé</option>
                        </select>

                        <select
                            v-model="reports.cashier_id"
                            class="form-select"
                            :disabled="reports.loading"
                        >
                            <option value="">Tous les caissiers</option>
                            <option
                                v-for="c in cashiers"
                                :key="c.id"
                                :value="String(c.id)"
                            >
                                {{ c.name || c.email || "#" + c.id }}
                            </option>
                        </select>

                        <div class="input-wrap">
                            <i class="fa-regular fa-calendar input-icon"></i>
                            <input
                                v-model="reports.from"
                                type="date"
                                class="form-control"
                                :disabled="reports.loading"
                            />
                        </div>
                        <div class="input-wrap">
                            <i class="fa-regular fa-calendar input-icon"></i>
                            <input
                                v-model="reports.to"
                                type="date"
                                class="form-control"
                                :disabled="reports.loading"
                            />
                        </div>

                        <button
                            class="btn-main"
                            @click="runReport"
                            :disabled="reports.loading"
                        >
                            <i class="fa-solid fa-play me-1"></i>Exécuter
                        </button>
                        <button
                            class="btn btn-quiet"
                            @click="resetReport"
                            :disabled="reports.loading"
                        >
                            Effacer
                        </button>
                    </div>
                </div>
            </div>

            <!-- Indicateurs -->
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                    <div class="stat">
                        <div class="text-muted small">Commandes</div>
                        <h4>{{ reports.totals.orders }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat">
                        <div class="text-muted small">Articles vendus</div>
                        <h4>{{ reports.totals.items }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat">
                        <div class="text-muted small">Brut</div>
                        <h4>{{ money(reports.totals.subtotal) }}</h4>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat">
                        <div class="text-muted small">Net</div>
                        <h4>{{ money(reports.totals.total) }}</h4>
                    </div>
                </div>
            </div>

            <!-- Tableau des résultats -->
            <div class="table-responsive soft-shadow" id="report-print-area">
                <table class="table align-middle pro-table">
                    <thead>
                        <tr class="text-muted">
                            <th style="min-width: 160px">
                                {{ reportGroupTitle }}
                            </th>
                            <th class="text-end">Commandes</th>
                            <th class="text-end">Articles</th>
                            <th class="text-end">Sous-total</th>
                            <th class="text-end">Remise</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="!reports.loading && !reports.rows.length">
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucune donnée.
                            </td>
                        </tr>
                        <tr
                            v-for="(r, i) in reports.rows"
                            :key="i"
                            class="row-hover"
                        >
                            <td class="fw-bold">{{ r.group }}</td>
                            <td class="text-end">{{ r.orders }}</td>
                            <td class="text-end">{{ r.items }}</td>
                            <td class="text-end">{{ money(r.subtotal) }}</td>
                            <td class="text-end">{{ money(r.discount) }}</td>
                            <td class="text-end fw-bold">
                                {{ money(r.total) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot v-if="reports.rows.length">
                        <tr>
                            <th>Total</th>
                            <th class="text-end">
                                {{ reports.totals.orders }}
                            </th>
                            <th class="text-end">{{ reports.totals.items }}</th>
                            <th class="text-end">
                                {{ money(reports.totals.subtotal) }}
                            </th>
                            <th class="text-end">
                                {{ money(reports.totals.discount) }}
                            </th>
                            <th class="text-end">
                                {{ money(reports.totals.total) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- ===== ONGLET TABLEAU DE BORD ===== -->
        <div v-show="activeTab === 'dashboard'" class="bo-body">
            <div class="row g-2">
                <!-- Cartes KPI -->
                <div
                    class="col-6 col-lg-3"
                    v-for="k in dashKpiList"
                    :key="k.key"
                >
                    <div class="stat stat-kpi">
                        <div class="text-muted small">{{ k.label }}</div>
                        <h4>{{ k.format(dashboard.kpis[k.key]) }}</h4>
                        <div v-if="k.subKey" class="small text-muted">
                            Préc. : {{ k.format(dashboard.kpis[k.subKey]) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tendance + Répartition -->
            <div class="row g-3 mt-1">
                <div class="col-12 col-lg-7">
                    <div class="bo-card h-100 soft-shadow">
                        <div
                            class="bo-head small d-flex justify-content-between align-items-center"
                        >
                            <strong>14 derniers jours — Ventes</strong>
                            <span class="text-muted small"
                                >{{ dashboard.trend14.length }} pts</span
                            >
                        </div>
                        <div class="bo-body">
                            <div class="spark-wrap">
                                <svg
                                    v-if="dashboard.trend14.length"
                                    :viewBox="
                                        '0 0 ' +
                                        dashboard.trend14.length * 8 +
                                        ' 60'
                                    "
                                    class="spark"
                                >
                                    <polyline
                                        :points="sparkPoints(dashboard.trend14)"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        opacity="0.9"
                                    />
                                </svg>
                                <div v-else class="text-muted small">
                                    Aucune donnée
                                </div>
                            </div>
                            <div
                                class="d-flex justify-content-between small text-muted mt-1"
                            >
                                <span>{{ dashTrendLabelStart }}</span>
                                <span>{{ dashTrendLabelEnd }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="bo-card h-100 soft-shadow">
                        <div class="bo-head small">
                            <strong>Moyens de paiement</strong>
                        </div>
                        <div class="bo-body">
                            <div
                                v-if="dashboard.byPayment.length"
                                class="barlist"
                            >
                                <div
                                    v-for="p in dashboard.byPayment"
                                    :key="p.method"
                                    class="barlist-row"
                                >
                                    <div class="barlist-label text-uppercase">
                                        {{ p.method }}
                                    </div>
                                    <div class="barlist-bar">
                                        <div
                                            class="barlist-fill"
                                            :style="{ width: p.pct + '%' }"
                                        ></div>
                                    </div>
                                    <div class="barlist-value">
                                        {{ money(p.total) }}
                                    </div>
                                </div>
                            </div>
                            <div v-else class="text-muted small">
                                Aucune donnée
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Articles / Caissiers -->
            <div class="row g-3 mt-1">
                <div class="col-12 col-lg-6">
                    <div class="bo-card h-100 soft-shadow">
                        <div class="bo-head small">
                            <strong>Meilleurs articles (par qté)</strong>
                        </div>
                        <div class="bo-body">
                            <table
                                class="table table-sm align-middle pro-table"
                            >
                                <thead class="text-muted">
                                    <tr>
                                        <th>Article</th>
                                        <th class="text-end">Qté</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!dashboard.topItems.length">
                                        <td
                                            colspan="3"
                                            class="text-muted small"
                                        >
                                            Aucune donnée
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(
                                            it, i
                                        ) in dashboard.topItems.slice(0, 8)"
                                        :key="i"
                                        class="row-hover"
                                    >
                                        <td
                                            class="text-truncate"
                                            :title="it.name"
                                        >
                                            {{ it.name }}
                                        </td>
                                        <td class="text-end">{{ it.qty }}</td>
                                        <td class="text-end">
                                            {{ money(it.total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="bo-card h-100 soft-shadow">
                        <div class="bo-head small">
                            <strong>Meilleurs caissiers (par ventes)</strong>
                        </div>
                        <div class="bo-body">
                            <table
                                class="table table-sm align-middle pro-table"
                            >
                                <thead class="text-muted">
                                    <tr>
                                        <th>Caissier</th>
                                        <th class="text-end">Commandes</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!dashboard.byCashier.length">
                                        <td
                                            colspan="3"
                                            class="text-muted small"
                                        >
                                            Aucune donnée
                                        </td>
                                    </tr>
                                    <tr
                                        v-for="(
                                            c, i
                                        ) in dashboard.byCashier.slice(0, 8)"
                                        :key="i"
                                        class="row-hover"
                                    >
                                        <td
                                            class="text-truncate"
                                            :title="c.name"
                                        >
                                            {{ c.name }}
                                        </td>
                                        <td class="text-end">{{ c.orders }}</td>
                                        <td class="text-end">
                                            {{ money(c.total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chargement -->
            <div v-if="dashboard.loading" class="text-center py-4">
                <div class="spinner-border text-primary"></div>
            </div>
        </div>

        <!-- Modal Détails -->
        <div
            v-if="showModal"
            class="modal fade show"
            style="display: block"
            aria-modal="true"
            role="dialog"
        >
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header quiet-surface">
                        <h5
                            class="modal-title fw-bold d-flex align-items-center gap-2"
                        >
                            Commande
                            {{ sel.order_code || sel.code || "#" + sel.id }}
                            <span
                                v-if="dailyNum(sel) != null"
                                class="badge badge-ticket"
                                >Ticket #{{ dailyNum(sel) }}</span
                            >
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeDetails"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="small text-muted">Date</div>
                                <div class="fw-bold">
                                    {{ fmtDate(sel.created_at, true) }}
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="small text-muted">Type</div>
                                <div class="fw-bold text-uppercase">
                                    {{ sel.order_type }}
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="small text-muted">Table</div>
                                <div class="fw-bold">
                                    {{ sel.table_number || "—" }}
                                </div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="small text-muted">Ticket</div>
                                <div class="fw-bold">
                                    {{
                                        dailyNum(sel) != null
                                            ? "#" + dailyNum(sel)
                                            : "—"
                                    }}
                                </div>
                            </div>
                            <div class="col-12 col-md-2">
                                <div class="small text-muted">Caissier</div>
                                <div
                                    class="fw-bold text-truncate"
                                    :title="cashierName(sel) || '—'"
                                >
                                    {{ cashierName(sel) || "—" }}
                                </div>
                            </div>
                        </div>

                        <hr />

                        <div class="mb-2 fw-bold">Articles</div>
                        <div class="table-responsive">
                            <table class="table small align-middle pro-table">
                                <thead class="text-muted">
                                    <tr>
                                        <th>Article</th>
                                        <th>Options</th>
                                        <th class="text-end">Unité</th>
                                        <th class="text-end">Qté</th>
                                        <th class="text-end">Ligne</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(it, i) in adaptItems(sel)"
                                        :key="i"
                                        class="row-hover"
                                    >
                                        <td class="fw-bold">
                                            {{ it.item_name }}
                                        </td>
                                        <td class="text-muted">
                                            <div
                                                v-for="(op, k) in it.options"
                                                :key="k"
                                            >
                                                • {{ op.variation_name }} :
                                                {{ op.option_name }}
                                                <span
                                                    v-if="
                                                        safeNum(
                                                            op.price_adjustment
                                                        )
                                                    "
                                                    >(+{{
                                                        money(
                                                            op.price_adjustment
                                                        )
                                                    }})</span
                                                >
                                            </div>
                                            <span
                                                v-if="
                                                    !it.options ||
                                                    !it.options.length
                                                "
                                                class="text-muted"
                                                >—</span
                                            >
                                        </td>
                                        <td class="text-end">
                                            {{ money(it.unit_price) }}
                                        </td>
                                        <td class="text-end">
                                            {{ it.quantity }}
                                        </td>
                                        <td class="text-end fw-bold">
                                            {{ money(it.line_total) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div style="min-width: 260px">
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted">Sous-total</span
                                    ><span>{{ money(sel.subtotal) }}</span>
                                </div>
                                <div
                                    class="d-flex justify-content-between"
                                    v-if="safeNum(sel.discount_amount)"
                                >
                                    <span class="text-muted">Remise</span
                                    ><span
                                        >-{{ money(sel.discount_amount) }}</span
                                    >
                                </div>
                                <hr />
                                <div class="d-flex justify-content-between">
                                    <strong>Total</strong
                                    ><strong>{{ money(sel.total) }}</strong>
                                </div>
                                <div
                                    class="small text-muted mt-1"
                                    v-if="payments(sel).length"
                                >
                                    Payé par :
                                    {{
                                        payments(sel)
                                            .map((p) => p.method?.toUpperCase())
                                            .join(", ")
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <span class="text-muted small">
                            {{ sel.notes || "" }}
                        </span>
                        <div class="d-flex gap-2">
                            <button
                                class="btn btn-quiet"
                                @click="printOrder(sel)"
                            >
                                <i class="fa-solid fa-print me-1"></i>Imprimer
                            </button>
                            <button class="btn-main" @click="closeDetails">
                                Fermer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="showModal"
            class="modal-backdrop fade show"
            @click="closeDetails"
        ></div>

        <!-- Voile de chargement global -->
        <div
            v-if="loading"
            style="
                position: fixed;
                inset: 0;
                background: rgba(255, 255, 255, 0.6);
                backdrop-filter: blur(2px);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1050;
            "
        >
            <div class="text-center">
                <div
                    class="spinner-border text-primary mb-2"
                    role="status"
                ></div>
                <div class="fw-bold" style="color: var(--c-primary)">
                    Chargement…
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrdersAdmin",
    props: {
        ordersEndpoint: { type: String, default: "/admin/orders" },
        cashiersEndpoint: { type: String, default: "/admin/cashiers" },
        meEndpoint: { type: String, default: "/api/admin/me" },
        logoutEndpoint: { type: String, default: "/admin/logout" },
        currency: { type: String, default: " DH" },
        brandName: { type: String, default: "" },
        reportsMax: { type: Number, default: 1000 },
        locale: { type: String, default: "fr-FR" }, // langue d’affichage des dates
    },
    data() {
        const t = new Date();
        const d = `${t.getFullYear()}-${String(t.getMonth() + 1).padStart(
            2,
            "0"
        )}-${String(t.getDate()).padStart(2, "0")}`;

        return {
            activeTab: "orders",
            density: "cozy",

            loading: false,
            loggingOut: false,

            orders: [],
            page: 1,
            lastPage: 1,
            total: 0,
            perPage: 15,

            filters: {
                q: "",
                order_type: "",
                status: "",
                from: d,
                to: d,
                cashier_id: "",
                only_mine: false,
            },

            cashiers: [],
            currentUser: null,

            showModal: false,
            sel: {},

            reports: {
                loading: false,
                rows: [],
                totals: {
                    orders: 0,
                    items: 0,
                    subtotal: 0,
                    discount: 0,
                    total: 0,
                },
                q: "",
                order_type: "",
                status: "",
                from: d,
                to: d,
                cashier_id: "",
                groupBy: "day",
            },

            dashboard: {
                loading: false,
                kpis: {
                    today: 0,
                    yesterday: 0,
                    week: 0,
                    month: 0,
                    todayOrders: 0,
                    avgTicket: 0,
                    prevAvgTicket: 0,
                },
                trend14: [],
                byPayment: [],
                topItems: [],
                byCashier: [],
            },
        };
    },
    computed: {
        activeTabLabel() {
            return this.activeTab === "orders"
                ? "Commandes"
                : this.activeTab === "reports"
                ? "Rapports"
                : "Tableau de bord";
        },
        avgTicket() {
            if (!this.orders.length) return 0;
            const s = this.sum(this.orders.map((o) => this.safeNum(o.total)));
            return s / this.orders.length;
        },
        pageCashierSummary() {
            if (!this.orders.length) return "";
            const map = {};
            this.orders.forEach((o) => {
                const key = this.cashierName(o) || "—";
                map[key] = (map[key] || 0) + 1;
            });
            const parts = Object.entries(map)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 3)
                .map(([name, count]) => `${name} (${count})`);
            return parts.join(", ");
        },
        cashierIndex() {
            const idx = {};
            this.cashiers.forEach((c) => {
                idx[String(c.id)] = c;
            });
            return idx;
        },
        reportGroupTitle() {
            const m = {
                day: "Jour",
                hour: "Heure",
                cashier: "Caissier",
                order_type: "Type de commande",
                payment_method: "Moyen de paiement",
                status: "Statut",
            };
            return m[this.reports.groupBy] || "Groupe";
        },
        dashKpiList() {
            return [
                {
                    key: "today",
                    label: "Ventes du jour",
                    format: (v) => this.money(v),
                },
                {
                    key: "yesterday",
                    subKey: null,
                    label: "Hier",
                    format: (v) => this.money(v),
                },
                {
                    key: "week",
                    label: "Cette semaine",
                    format: (v) => this.money(v),
                },
                {
                    key: "month",
                    label: "Ce mois",
                    format: (v) => this.money(v),
                },
                {
                    key: "todayOrders",
                    label: "Commandes du jour",
                    format: (v) => String(v || 0),
                },
                {
                    key: "avgTicket",
                    subKey: "prevAvgTicket",
                    label: "Panier moyen",
                    format: (v) => this.money(v),
                },
            ];
        },
        dashTrendLabelStart() {
            if (!this.dashboard.trend14.length) return "";
            return this.dashboard.trend14[0]?.date || "";
        },
        dashTrendLabelEnd() {
            if (!this.dashboard.trend14.length) return "";
            return (
                this.dashboard.trend14[this.dashboard.trend14.length - 1]
                    ?.date || ""
            );
        },

        // Totaux de la page commandes
        pageTotals() {
            return {
                subtotal: this.sum(
                    this.orders.map((o) => this.safeNum(o.subtotal))
                ),
                discount: this.sum(
                    this.orders.map((o) => this.safeNum(o.discount_amount))
                ),
                total: this.sum(this.orders.map((o) => this.safeNum(o.total))),
            };
        },
        pagePaymentBreakdown() {
            const map = {};
            let totalAll = 0;
            this.orders.forEach((o) => {
                const t = this.safeNum(o.total);
                totalAll += t;
                const methods = this.payments(o);
                if (!methods.length) {
                    map["—"] = (map["—"] || 0) + t;
                } else {
                    methods.forEach((m) => {
                        const key = (m.method || "—").toUpperCase();
                        map[key] = (map[key] || 0) + t;
                    });
                }
            });
            return Object.entries(map)
                .map(([method, total]) => ({
                    method,
                    total,
                    pct: totalAll ? Math.round((total * 100) / totalAll) : 0,
                }))
                .sort((a, b) => b.total - a.total);
        },
        activeChips() {
            const chips = [];
            if (this.filters.q) chips.push(`Requête : ${this.filters.q}`);
            if (this.filters.order_type)
                chips.push(`Type : ${this.filters.order_type}`);
            if (this.filters.status)
                chips.push(`Statut : ${this.filters.status}`);
            if (this.filters.cashier_id) {
                const c = this.cashierIndex[String(this.filters.cashier_id)];
                chips.push(
                    `Caissier : ${c?.name || "#" + this.filters.cashier_id}`
                );
            }
            if (this.filters.from || this.filters.to)
                chips.push(`Plage : ${this.filters.from} → ${this.filters.to}`);
            if (this.filters.only_mine) chips.push(`Uniquement mes commandes`);
            return chips;
        },
    },
    async mounted() {
        await this.bootstrap();
    },
    methods: {
        // ===== utilitaires =====
        money(n) {
            return parseFloat(n || 0).toFixed(2) + this.currency;
        },
        safeNum(n) {
            const v = Number(n);
            return isFinite(v) ? v : 0;
        },
        sum(arr) {
            return (arr || []).reduce((a, c) => a + this.safeNum(c), 0);
        },
        fmtDate(d, withTime = false) {
            const dt = d ? new Date(d) : new Date();
            return withTime
                ? dt.toLocaleString(this.locale)
                : dt.toLocaleDateString(this.locale);
        },
        startOfWeek(date = new Date()) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = (day + 6) % 7; // lundi
            d.setDate(d.getDate() - diff);
            return new Date(d.getFullYear(), d.getMonth(), d.getDate());
        },
        endOfMonth(date = new Date()) {
            return new Date(date.getFullYear(), date.getMonth() + 1, 0);
        },
        toIsoDate(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, "0");
            const d = String(date.getDate()).padStart(2, "0");
            return `${y}-${m}-${d}`;
        },
        dateKey(d) {
            // clé locale sûre AAAA-MM-JJ
            const dt = new Date(d);
            return this.toIsoDate(dt);
        },
        setRange(which) {
            const now = new Date();
            if (which === "today") {
                const d = this.toIsoDate(now);
                this.filters.from = d;
                this.filters.to = d;
            } else if (which === "yesterday") {
                const y = new Date(now);
                y.setDate(y.getDate() - 1);
                const d = this.toIsoDate(y);
                this.filters.from = d;
                this.filters.to = d;
            } else if (which === "week") {
                const s = this.startOfWeek(now);
                this.filters.from = this.toIsoDate(s);
                this.filters.to = this.toIsoDate(now);
            } else if (which === "month") {
                const first = new Date(now.getFullYear(), now.getMonth(), 1);
                const last = this.endOfMonth(now);
                this.filters.from = this.toIsoDate(first);
                this.filters.to = this.toIsoDate(last);
            }
            this.applyFilters();
        },
        setRangeFor(target, which) {
            const now = new Date();
            const obj = target === "reports" ? this.reports : this.filters;
            if (which === "today") {
                const d = this.toIsoDate(now);
                obj.from = d;
                obj.to = d;
            } else if (which === "yesterday") {
                const y = new Date(now);
                y.setDate(y.getDate() - 1);
                const d = this.toIsoDate(y);
                obj.from = d;
                obj.to = d;
            } else if (which === "week") {
                const s = this.startOfWeek(now);
                obj.from = this.toIsoDate(s);
                obj.to = this.toIsoDate(now);
            } else if (which === "month") {
                const first = new Date(now.getFullYear(), now.getMonth(), 1);
                const last = this.endOfMonth(now);
                obj.from = this.toIsoDate(first);
                obj.to = this.toIsoDate(last);
            }
            if (target === "reports") this.runReport();
        },

        cashierName(o) {
            const direct =
                o.cashier?.name ||
                o.created_by_name ||
                o.user?.name ||
                o.created_by_user?.name;
            if (direct) return direct;
            const id = String(o.created_by ?? o.cashier_id ?? "");
            if (id && this.cashierIndex[id]) {
                return (
                    this.cashierIndex[id].name ||
                    this.cashierIndex[id].email ||
                    "#" + id
                );
            }
            return o.cashier?.email || o.created_by_email || "";
        },
        dailyNum(o) {
            const v = o?.daily_order ?? o?.daily;
            const n = Number(v);
            return isFinite(n) && n >= 0 ? n : null;
        },
        syncMine() {
            if (this.filters.only_mine && this.currentUser?.id) {
                this.filters.cashier_id = String(this.currentUser.id);
            } else if (!this.filters.only_mine) {
                this.filters.cashier_id = "";
            }
            this.applyFilters();
        },

        payments(o) {
            const p =
                (o && (o.payments || (o.payment ? [o.payment] : []))) || [];
            return p.map((x) => ({
                method: x.method || x.type || "cash",
                amount: this.safeNum(x.amount),
                amount_given: this.safeNum(x.amount_given),
                change_due: this.safeNum(x.change_due),
            }));
        },
        adaptItems(o) {
            const items = o.items || o.order_items || [];
            return items.map((it) => {
                const rawOpts =
                    it.options || it.order_item_options || it.selections || [];
                const opts = [];
                rawOpts.forEach((r) => {
                    if (r.options && Array.isArray(r.options)) {
                        r.options.forEach((o2) =>
                            opts.push({
                                variation_name:
                                    r.name || r.variation_name || "",
                                option_name: o2.name || o2.option_name || "",
                                price_adjustment: this.safeNum(
                                    o2.adj || o2.price_adjustment
                                ),
                            })
                        );
                    } else {
                        opts.push({
                            variation_name: r.variation_name || r.name || "",
                            option_name: r.option_name || r.name || "",
                            price_adjustment: this.safeNum(
                                r.price_adjustment || r.adj
                            ),
                        });
                    }
                });
                const qty = this.safeNum(it.quantity);
                const unit = this.safeNum(it.unit_price || it.price);
                return {
                    item_name: it.item_name || it.name || "",
                    quantity: qty || 1,
                    unit_price: unit,
                    options: opts,
                    line_total: this.safeNum(
                        it.line_total || unit * (qty || 1)
                    ),
                };
            });
        },

        qs(obj) {
            const p = [];
            Object.keys(obj).forEach((k) => {
                const v = obj[k];
                if (v !== undefined && v !== null && String(v).length) {
                    p.push(encodeURIComponent(k) + "=" + encodeURIComponent(v));
                }
            });
            return p.join("&");
        },
        async bootstrap() {
            await Promise.all([this.fetchMe(), this.fetchCashiers()]);
            await this.fetchOrders();
            this.fetchDashboard();
        },
        async fetchMe() {
            try {
                const res = await fetch(this.meEndpoint, {
                    credentials: "include",
                    headers: { Accept: "application/json" },
                });
                if (res.ok) {
                    const j = await res.json();
                    this.currentUser = j || null;
                } else if (res.status === 401 || res.status === 419) {
                    window.location.href = "/admin/login";
                }
            } catch (_) {}
        },
        async fetchCashiers() {
            try {
                const res = await fetch(this.cashiersEndpoint, {
                    headers: { Accept: "application/json" },
                    credentials: "include",
                });
                if (!res.ok) return;
                const j = await res.json();
                const list = Array.isArray(j?.data)
                    ? j.data
                    : Array.isArray(j)
                    ? j
                    : [];
                this.cashiers = list
                    .map((x) => ({
                        id:
                            x.id ??
                            x.user_id ??
                            x.cashier_id ??
                            x.uuid ??
                            x.code,
                        name: x.name ?? x.full_name ?? x.username ?? "",
                        email: x.email ?? "",
                    }))
                    .filter((c) => c.id != null);
            } catch (_) {
                /* ignore */
            }
        },
        normalizeDateOrderFor(obj) {
            const f = obj.from,
                t = obj.to;
            if (f && t && f > t) {
                const tmp = obj.from;
                obj.from = obj.to;
                obj.to = tmp;
            }
        },
        normalizeDateOrder() {
            this.normalizeDateOrderFor(this.filters);
        },
        async fetchOrders() {
            this.loading = true;
            try {
                this.normalizeDateOrder();
                const createdBy =
                    this.filters.only_mine && this.currentUser?.id
                        ? String(this.currentUser.id)
                        : this.filters.cashier_id || "";

                const params = {
                    page: this.page,
                    per_page: this.perPage,
                    q: this.filters.q,
                    order_type: this.filters.order_type,
                    status: this.filters.status,
                    from: this.filters.from,
                    to: this.filters.to,
                    cashier_id: createdBy,
                    created_by: createdBy,
                    only_mine: this.filters.only_mine ? 1 : "",
                };
                const url = this.ordersEndpoint + "?" + this.qs(params);
                const res = await fetch(url, {
                    headers: { Accept: "application/json" },
                    credentials: "include",
                });
                const json = await res.json();

                if (Array.isArray(json.data)) {
                    this.orders = json.data;
                    this.total = json.total ?? json.data.length;
                    this.page = json.current_page ?? this.page;
                    this.lastPage = json.last_page ?? 1;
                    this.perPage = json.per_page ?? this.perPage;
                } else if (Array.isArray(json)) {
                    this.orders = json;
                    this.total = json.length;
                    this.lastPage = 1;
                } else {
                    this.orders = [];
                    this.total = 0;
                    this.lastPage = 1;
                }
            } catch (e) {
                alert("Échec du chargement des commandes.");
            } finally {
                this.loading = false;
            }
        },

        // ===== actions commandes =====
        reload() {
            this.fetchOrders();
        },
        applyFilters() {
            this.page = 1;
            this.fetchOrders();
        },
        resetFilters() {
            const d = this.toIsoDate(new Date());
            this.filters.q = "";
            this.filters.order_type = "";
            this.filters.status = "";
            this.filters.from = d;
            this.filters.to = d;
            this.filters.cashier_id = "";
            this.filters.only_mine = false;
            this.page = 1;
            this.fetchOrders();
        },
        go(p) {
            this.page = Math.min(Math.max(1, p), this.lastPage);
            this.fetchOrders();
        },
        openDetails(order) {
            this.sel = order;
            this.showModal = true;
        },
        closeDetails() {
            this.showModal = false;
            this.sel = {};
        },
        printOrder(order) {
            const items = this.adaptItems(order);
            const w = window.open("", "PRINT", "height=600,width=380");
            w.document.write(`<html><head><title>Ticket</title><style>
        body{font-family:monospace;padding:8px}
        .line{display:flex;justify-content:space-between}
        .small{font-size:12px;color:#555}
        hr{border:none;border-top:1px dashed #999;margin:6px 0}
      </style></head><body>`);
            w.document.write(`<h2>${this.brandName || "Ticket"}</h2><hr>`);
            const cashier = this.cashierName(order);
            const ticket = this.dailyNum(order);
            if (ticket != null) {
                w.document.write(`<div>Ticket : #${ticket}</div>`);
            }
            w.document.write(
                `<div>Commande : ${
                    order.order_code || order.code || "#" + order.id
                }</div>`
            );
            w.document.write(
                `<div class="small">${this.fmtDate(
                    order.created_at,
                    true
                )} • ${String(order.order_type || "").toUpperCase()}${
                    order.table_number ? " • T" + order.table_number : ""
                }${cashier ? " • Caissier : " + cashier : ""}</div><hr>`
            );
            items.forEach((l) => {
                w.document.write(
                    `<div><strong>${l.item_name}</strong> x${l.quantity}</div>`
                );
                (l.options || []).forEach((op) => {
                    const plus = this.safeNum(op.price_adjustment)
                        ? ` (+${this.money(op.price_adjustment)})`
                        : "";
                    w.document.write(
                        `<div class="small"> - ${op.variation_name} : ${op.option_name}${plus}</div>`
                    );
                });
                w.document.write(
                    `<div class="line"><span class="small">Unité :</span><span>${this.money(
                        l.unit_price
                    )}</span></div>`
                );
                w.document.write(
                    `<div class="line"><span class="small">Ligne :</span><span>${this.money(
                        l.line_total
                    )}</span></div><hr>`
                );
            });
            w.document.write(
                `<div class="line"><strong>Sous-total</strong><strong>${this.money(
                    this.safeNum(order.subtotal)
                )}</strong></div>`
            );
            if (this.safeNum(order.discount_amount)) {
                w.document.write(
                    `<div class="line"><span class="small">Remise</span><span class="small">-${this.money(
                        order.discount_amount
                    )}</span></div>`
                );
            }
            w.document.write(
                `<div class="line"><strong>Total</strong><strong>${this.money(
                    this.safeNum(order.total)
                )}</strong></div><hr>`
            );
            const pay = this.payments(order)[0];
            if (pay) {
                w.document.write(
                    `<div class="small">Payé par : ${String(
                        pay.method || ""
                    ).toUpperCase()} • Donné : ${this.money(
                        pay.amount_given
                    )} • Monnaie : ${this.money(pay.change_due)}</div>`
                );
            }
            w.document.write(
                `<p class="small" style="text-align:center;margin-top:10px">*** Merci ! ***</p>`
            );
            w.document.write(`</body></html>`);
            w.document.close();
            w.focus();
            w.print();
            w.close();
        },

        // ===== Logout (admin session) =====
        csrfToken() {
            const meta = document.querySelector('meta[name="csrf-token"]');
            return meta ? meta.getAttribute("content") : "";
        },
        async logout() {
            if (this.loggingOut) return;
            this.loggingOut = true;
            try {
                const res = await fetch(this.logoutEndpoint, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": this.csrfToken(),
                        Accept: "application/json",
                    },
                    credentials: "include",
                });
                if (res.ok || res.status === 204) {
                    this.currentUser = null;
                    window.location.href = "/admin/login";
                    return;
                }
                if (res.status === 419 || res.status === 401) {
                    window.location.href = "/admin/login";
                    return;
                }
                const txt = await res.text();
                alert("Déconnexion échouée (" + res.status + "): " + txt);
            } catch (_) {
                alert("Déconnexion échouée.");
            } finally {
                this.loggingOut = false;
            }
        },

        // ===== onglets =====
        setTab(t) {
            this.activeTab = t;
            if (t === "dashboard") this.fetchDashboard();
        },

        // ===== RAPPORTS =====
        async runReport() {
            this.reports.loading = true;
            try {
                this.normalizeDateOrderFor(this.reports);
                const orders = await this.fetchAllOrdersForRange({
                    from: this.reports.from,
                    to: this.reports.to,
                    q: this.reports.q,
                    order_type: this.reports.order_type,
                    status: this.reports.status,
                    cashier_id: this.reports.cashier_id,
                });
                const { rows, totals } = this.aggregateReport(
                    orders,
                    this.reports.groupBy
                );
                this.reports.rows = rows;
                this.reports.totals = totals;
            } catch (e) {
                alert("Échec de l’exécution du rapport.");
            } finally {
                this.reports.loading = false;
            }
        },
        resetReport() {
            const d = this.toIsoDate(new Date());
            this.reports.q = "";
            this.reports.order_type = "";
            this.reports.status = "";
            this.reports.from = d;
            this.reports.to = d;
            this.reports.cashier_id = "";
            this.reports.groupBy = "day";
            this.reports.rows = [];
            this.reports.totals = {
                orders: 0,
                items: 0,
                subtotal: 0,
                discount: 0,
                total: 0,
            };
        },
        async fetchAllOrdersForRange({
            from,
            to,
            q,
            order_type,
            status,
            cashier_id,
        }) {
            const params = {
                page: 1,
                per_page: this.reportsMax,
                from,
                to,
                q,
                order_type,
                status,
                cashier_id,
                created_by: cashier_id,
            };
            const url = this.ordersEndpoint + "?" + this.qs(params);
            const res = await fetch(url, {
                headers: { Accept: "application/json" },
                credentials: "include",
            });
            const json = await res.json();
            if (Array.isArray(json.data)) return json.data;
            if (Array.isArray(json)) return json;
            return [];
        },
        aggregateReport(orders, groupBy) {
            const bucket = {};
            const add = (key, o) => {
                if (!bucket[key])
                    bucket[key] = {
                        group: key,
                        orders: 0,
                        items: 0,
                        subtotal: 0,
                        discount: 0,
                        total: 0,
                    };
                const b = bucket[key];
                b.orders += 1;
                const items = this.adaptItems(o);
                b.items += items.reduce(
                    (s, it) => s + this.safeNum(it.quantity),
                    0
                );
                b.subtotal += this.safeNum(o.subtotal);
                b.discount += this.safeNum(o.discount_amount);
                b.total += this.safeNum(o.total);
            };
            orders.forEach((o) => {
                let key = "—";
                if (groupBy === "day") {
                    key = this.dateKey(o.created_at);
                } else if (groupBy === "hour") {
                    const dt = o.created_at
                        ? new Date(o.created_at)
                        : new Date();
                    const dkey = this.dateKey(dt);
                    const hh = ("0" + dt.getHours()).slice(-2);
                    key = `${dkey} ${hh}:00`;
                } else if (groupBy === "cashier") {
                    key = this.cashierName(o) || "—";
                } else if (groupBy === "order_type") {
                    key = (o.order_type || "—").toUpperCase();
                } else if (groupBy === "payment_method") {
                    const methods = this.payments(o).map((p) =>
                        (p.method || "—").toUpperCase()
                    );
                    key = methods.length ? methods.join(", ") : "—";
                } else if (groupBy === "status") {
                    key = (o.status || "paid").toUpperCase();
                }
                add(key, o);
            });
            const rows = Object.values(bucket).sort((a, b) =>
                a.group.localeCompare(b.group)
            );
            const totals = rows.reduce(
                (t, r) => ({
                    orders: t.orders + r.orders,
                    items: t.items + r.items,
                    subtotal: t.subtotal + r.subtotal,
                    discount: t.discount + r.discount,
                    total: t.total + r.total,
                }),
                { orders: 0, items: 0, subtotal: 0, discount: 0, total: 0 }
            );
            return { rows, totals };
        },
        exportReport() {
            if (!this.reports.rows.length) return;
            const header = [
                this.reportGroupTitle,
                "Commandes",
                "Articles",
                "Sous-total",
                "Remise",
                "Total",
            ];
            const lines = [header.join(",")];
            this.reports.rows.forEach((r) => {
                lines.push(
                    [
                        `"${String(r.group).replaceAll('"', '""')}"`,
                        r.orders,
                        r.items,
                        r.subtotal.toFixed(2),
                        r.discount.toFixed(2),
                        r.total.toFixed(2),
                    ].join(",")
                );
            });
            lines.push(
                [
                    '"TOTAL"',
                    this.reports.totals.orders,
                    this.reports.totals.items,
                    this.reports.totals.subtotal.toFixed(2),
                    this.reports.totals.discount.toFixed(2),
                    this.reports.totals.total.toFixed(2),
                ].join(",")
            );
            const blob = new Blob([lines.join("\n")], {
                type: "text/csv;charset=utf-8;",
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `rapport_${this.reports.from}_au_${this.reports.to}.csv`;
            document.body.appendChild(a);
            a.click();
            URL.revokeObjectURL(url);
            a.remove();
        },
        printReport() {
            const area = document.getElementById("report-print-area");
            if (!area) return;
            const w = window.open("", "PRINT", "height=800,width=1000");
            w.document.write(`<html><head><title>Rapport</title><style>
        body{font-family:system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial; padding:16px}
        table{width:100%; border-collapse:collapse}
        th,td{border:1px solid #ddd; padding:6px}
        thead th{background:#f5f5f5}
        tfoot th{background:#f9f9f9}
        h2{margin:0 0 8px 0}
        .muted{color:#666; font-size:12px}
      </style></head><body>`);
            w.document.write(`<h2>${this.brandName || "Rapport POS"}</h2>`);
            w.document.write(
                `<div class="muted">Plage : ${this.reports.from} → ${this.reports.to} • Groupe : ${this.reportGroupTitle}</div><br/>`
            );
            w.document.write(area.outerHTML);
            w.document.write(`</body></html>`);
            w.document.close();
            w.focus();
            w.print();
            w.close();
        },

        // ===== TABLEAU DE BORD =====
        async fetchDashboard() {
            if (this.dashboard.loading) return;
            this.dashboard.loading = true;
            try {
                const now = new Date();
                const start = new Date(now);
                start.setDate(start.getDate() - 13);
                const from = this.toIsoDate(start);
                const to = this.toIsoDate(now);

                const orders = await this.fetchAllOrdersForRange({ from, to });
                this.computeDashboard(orders, from, to);
            } catch (_) {
                // ignore
            } finally {
                this.dashboard.loading = false;
            }
        },
        computeDashboard(orders, from, to) {
            const byDay = {};
            const addDay = (d, v) => {
                byDay[d] = (byDay[d] || 0) + v;
            };
            orders.forEach((o) => {
                const day = this.dateKey(o.created_at);
                addDay(day, this.safeNum(o.total));
            });

            const series = [];
            const s = new Date(from);
            const e = new Date(to);
            for (let d = new Date(s); d <= e; d.setDate(d.getDate() + 1)) {
                const key = this.toIsoDate(d);
                series.push({ date: key, total: this.safeNum(byDay[key]) });
            }
            this.dashboard.trend14 = series;

            const todayKey = this.dateKey(new Date());
            const y = new Date();
            y.setDate(y.getDate() - 1);
            const yesterdayKey = this.dateKey(y);
            const startWeek = this.startOfWeek(new Date());
            const startMonth = new Date(
                new Date().getFullYear(),
                new Date().getMonth(),
                1
            );

            const sumIf = (pred) =>
                this.sum(orders.filter(pred).map((o) => this.safeNum(o.total)));
            const countIf = (pred) => orders.filter(pred).length;

            const kpis = {
                today: sumIf((o) => this.dateKey(o.created_at) === todayKey),
                yesterday: sumIf(
                    (o) => this.dateKey(o.created_at) === yesterdayKey
                ),
                week: sumIf((o) => new Date(o.created_at) >= startWeek),
                month: sumIf((o) => new Date(o.created_at) >= startMonth),
                todayOrders: countIf(
                    (o) => this.dateKey(o.created_at) === todayKey
                ),
                avgTicket: 0,
                prevAvgTicket: 0,
            };

            const todayOrders = orders.filter(
                (o) => this.dateKey(o.created_at) === todayKey
            );
            const prevOrders = orders.filter(
                (o) => this.dateKey(o.created_at) === yesterdayKey
            );
            kpis.avgTicket = todayOrders.length
                ? this.sum(todayOrders.map((o) => this.safeNum(o.total))) /
                  todayOrders.length
                : 0;
            kpis.prevAvgTicket = prevOrders.length
                ? this.sum(prevOrders.map((o) => this.safeNum(o.total))) /
                  prevOrders.length
                : 0;

            this.dashboard.kpis = kpis;

            const payMap = {};
            orders.forEach((o) => {
                const methods = this.payments(o);
                if (!methods.length) {
                    payMap["—"] = (payMap["—"] || 0) + this.safeNum(o.total);
                } else {
                    methods.forEach((m) => {
                        const key = (m.method || "—").toUpperCase();
                        payMap[key] =
                            (payMap[key] || 0) + this.safeNum(o.total);
                    });
                }
            });
            const payTotal = Object.values(payMap).reduce((a, c) => a + c, 0);
            this.dashboard.byPayment = Object.entries(payMap)
                .map(([method, total]) => ({
                    method,
                    total,
                    pct: payTotal ? Math.round((total * 100) / payTotal) : 0,
                }))
                .sort((a, b) => b.total - a.total);

            const itemMap = {};
            orders.forEach((o) => {
                this.adaptItems(o).forEach((it) => {
                    const name = it.item_name || "—";
                    if (!itemMap[name])
                        itemMap[name] = { name, qty: 0, total: 0 };
                    itemMap[name].qty += this.safeNum(it.quantity);
                    itemMap[name].total += this.safeNum(it.line_total);
                });
            });
            this.dashboard.topItems = Object.values(itemMap).sort(
                (a, b) => b.qty - a.qty
            );

            const cMap = {};
            orders.forEach((o) => {
                const name = this.cashierName(o) || "—";
                if (!cMap[name]) cMap[name] = { name, orders: 0, total: 0 };
                cMap[name].orders += 1;
                cMap[name].total += this.safeNum(o.total);
            });
            this.dashboard.byCashier = Object.values(cMap).sort(
                (a, b) => b.total - a.total
            );
        },
        sparkPoints(series) {
            if (!series.length) return "";
            const h = 60;
            const max = Math.max(...series.map((s) => s.total), 1);
            return series
                .map((s, i) => {
                    const x = i * 8 + 4;
                    const y = h - (s.total / max) * (h - 6) - 3;
                    return `${x},${y}`;
                })
                .join(" ");
        },
    },
};
</script>

<style scoped>
/* =========================== */
/* Thème doux et reposant      */
/* =========================== */
.bo-card {
    --c-bg: #f7f8fa;
    --c-surface: #ffffff;
    --c-quiet: #f3f6f7;
    --c-border: #e6eaee;
    --c-muted: #6b7280;
    --c-text: #111827;

    --c-primary: #0ea5a6;
    --c-primary-qs: #e9f7f7;

    background: var(--c-bg);
    border: 1px solid var(--c-border);
    border-radius: 14px;
    overflow: hidden;
}

/* Topbar */
.topbar {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    gap: 0.75rem;
    padding: 0.8rem 1rem;
    background: linear-gradient(180deg, var(--c-surface), var(--c-quiet));
    border-bottom: 1px solid var(--c-border);
    position: sticky;
    top: 0;
    z-index: 5;
}
.topbar-left {
    display: flex;
    align-items: center;
}
.brand {
    display: flex;
    align-items: center;
    gap: 0.8rem;
}
.brand-mark {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--c-primary-qs);
    color: var(--c-primary);
    font-size: 18px;
    border: 1px solid var(--c-border);
}
.brand-line {
    font-weight: 800;
    letter-spacing: 0.2px;
}
.crumbs {
    color: var(--c-muted);
    font-size: 0.85rem;
}
.text-primary {
    color: var(--c-primary);
}

.topbar-center {
    display: flex;
    justify-content: center;
}
.segmented {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: 12px;
    padding: 0.25rem;
    display: flex;
    gap: 0.25rem;
}
.segmented.small {
    padding: 0.15rem;
}
.seg-btn {
    border: 0;
    background: transparent;
    padding: 0.45rem 0.7rem;
    border-radius: 8px;
    font-weight: 700;
    color: var(--c-muted);
}
.seg-btn.active {
    background: var(--c-primary-qs);
    color: var(--c-primary);
    border: 1px solid var(--c-border);
}
.seg-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 999px;
    background: var(--c-primary);
    margin-left: 0.35rem;
    vertical-align: middle;
}

.topbar-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.density-wrap .seg-btn {
    padding: 0.25rem 0.45rem;
}

/* Sections */
.bo-body {
    padding: 1rem;
}
.stat {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: 12px;
    padding: 0.75rem 1rem;
}
.stat-kpi h4 {
    margin-bottom: 0;
}
.pill {
    background: var(--c-quiet);
    border: 1px solid var(--c-border);
    border-radius: 999px;
    padding: 0.25rem 0.6rem;
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--c-text);
}

/* Boutons */
.btn-main {
    background: var(--c-primary);
    color: #fff;
    border: 1px solid var(--c-primary);
    border-radius: 10px;
    padding: 0.45rem 0.7rem;
    font-weight: 700;
}
.btn-main:disabled {
    opacity: 0.6;
}
.btn-quiet {
    background: var(--c-surface);
    color: var(--c-text);
    border: 1px solid var(--c-border);
    border-radius: 10px;
    padding: 0.35rem 0.6rem;
    font-weight: 600;
}
.btn-chip {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    color: var(--c-text);
    border-radius: 999px;
    padding: 0.2rem 0.6rem;
    font-weight: 600;
}
.btn-link {
    background: transparent;
    border: 0;
    padding: 0;
    color: var(--c-primary);
}

/* Inputs */
.search-row {
    display: grid;
    gap: 0.5rem;
    grid-template-columns: 1.2fr repeat(3, 0.8fr) repeat(2, 0.9fr) 0.5fr auto auto;
}
@media (max-width: 1200px) {
    .search-row {
        grid-template-columns: 1fr 1fr 1fr;
    }
}
@media (max-width: 768px) {
    .search-row {
        grid-template-columns: 1fr;
    }
}
.input-wrap {
    position: relative;
}
.input-icon {
    position: absolute;
    left: 0.6rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--c-muted);
    font-size: 0.9rem;
}
.input-wrap .form-control {
    padding-left: 2rem;
}
.form-control,
.form-select {
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: 10px;
}
.small-w {
    max-width: 120px;
}

/* Filtres actifs */
.active-chips {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.35rem;
    margin-top: 0.5rem;
}
.chip {
    background: #fff;
    border: 1px dashed var(--c-border);
    border-radius: 999px;
    padding: 0.15rem 0.55rem;
    font-size: 0.8rem;
}

/* Disposition 2 colonnes */
.content-grid {
    display: grid;
    gap: 1rem;
    grid-template-columns: 1fr 320px;
}
@media (max-width: 1200px) {
    .content-grid {
        grid-template-columns: 1fr;
    }
}
.content-main {
    min-width: 0;
}
.side-rail {
    position: sticky;
    top: 92px;
    align-self: start;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

/* Table */
.table {
    color: var(--c-text);
}
.pro-table thead th {
    background: var(--c-quiet);
    border-bottom: 1px solid var(--c-border) !important;
}
.pro-table tbody tr:nth-child(even) {
    background: #fafbfc;
}
.row-hover:hover {
    background: #f0f4f6;
}
.sticky-th {
    position: sticky;
    top: 0;
    z-index: 1;
    background: var(--c-quiet);
}

/* Badges & actions */
.badge-soft {
    background: #f6f7f8;
    border: 1px solid var(--c-border);
    padding: 0.2rem 0.45rem;
    border-radius: 0.35rem;
    color: var(--c-text);
}
.badge-ticket {
    background: #fff6e5;
    border: 1px solid #fcd9a3;
    color: #92400e;
    padding: 0.2rem 0.45rem;
    border-radius: 0.35rem;
    font-weight: 700;
}
.row-actions .btn-ghost {
    background: transparent;
    border: 1px solid var(--c-border);
    border-radius: 8px;
}

/* Collants */
.tools-sticky {
    position: sticky;
    top: 64px;
    z-index: 4;
}

/* Graphiques simples */
.spark-wrap {
    overflow-x: auto;
}
.spark {
    width: 100%;
    height: 80px;
    color: var(--c-primary);
}
.barlist {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.barlist-row {
    display: grid;
    grid-template-columns: 1fr 6fr auto;
    gap: 0.5rem;
    align-items: center;
}
.barlist-label {
    font-weight: 600;
    color: var(--c-text);
}
.barlist-bar {
    background: #e9eef2;
    border-radius: 999px;
    height: 8px;
    overflow: hidden;
}
.barlist-fill {
    height: 100%;
    background: var(--c-primary);
}
.barlist-value {
    font-variant-numeric: tabular-nums;
}

.soft-shadow {
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.05);
}

/* Densité */
.is-compact .table.align-middle tbody td,
.is-compact .table.align-middle thead th {
    padding-top: 0.35rem;
    padding-bottom: 0.35rem;
}
.is-compact .form-control,
.is-compact .form-select {
    padding-top: 0.3rem;
    padding-bottom: 0.3rem;
}
.is-compact .seg-btn {
    padding: 0.3rem 0.5rem;
}

/* Utils */
.text-muted {
    color: var(--c-muted) !important;
}
.mx-1 {
    margin-left: 0.25rem;
    margin-right: 0.25rem;
}
</style>
