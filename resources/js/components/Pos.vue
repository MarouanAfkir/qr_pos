<template>
    <div :dir="isRTL ? 'rtl' : 'ltr'">
        <!-- ===== Header ===== -->
        <div class="pos-header">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="brand-wrap">
                        <div class="logo-ring">
                            <img :src="logoSrc" alt="Logo" />
                        </div>
                        <div class="brand-title">
                            <h1>
                                {{ restaurantName }}
                                <span
                                    class="badge-pill ms-1"
                                    style="
                                        background: #fff;
                                        border: 1px solid #e4f4ea;
                                        font-size: 0.7rem;
                                    "
                                    >POS</span
                                >
                            </h1>
                            <small>{{ tagline }}</small>
                        </div>
                    </div>

                    <div class="header-tools">
                        <!-- Address (optional) -->
                        <div
                            v-if="restaurantAddress"
                            class="text-muted d-none d-md-block me-2"
                        >
                            <i class="fa-solid fa-location-dot"></i>
                            {{ restaurantAddress }}
                        </div>

                        <!-- Pending orders (offline queue) -->
                        <button
                            v-if="pendingOrders.length"
                            class="btn-circle position-relative"
                            :title="
                                'Retry pending (' + pendingOrders.length + ')'
                            "
                            @click="retryPending"
                        >
                            <i class="fa-solid fa-cloud-slash"></i>
                            <span class="badge-pill pending-dot"
                                >{{ pendingOrders.length }}
                            </span>
                        </button>

                        <!-- Lang switcher -->
                        <div class="dropdown">
                            <button
                                class="btn-pill d-flex align-items-center gap-2"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="fa-solid fa-globe"></i>
                                <span>{{ language.toUpperCase() }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li v-for="lang in languages" :key="lang.code">
                                    <a
                                        class="dropdown-item d-flex justify-content-between"
                                        :class="{
                                            active: lang.code === language,
                                        }"
                                        href="#"
                                        @click.prevent="switchLang(lang.code)"
                                    >
                                        <span>{{
                                            lang.code.toUpperCase()
                                        }}</span>
                                        <small class="text-muted">{{
                                            lang.name
                                        }}</small>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- subtle divider for better grouping -->
                        <span class="tools-sep" aria-hidden="true"></span>

                        <!-- Single enhanced Tables button (icon + inline T# state) -->
                        <button
                            class="btn-pill d-flex align-items-center gap-2"
                            :title="'Choose Table'"
                            @click="openTables()"
                            :aria-pressed="showTables ? 'true' : 'false'"
                            :disabled="orderType !== 'dinein'"
                            :style="{
                                padding: '0.45rem 0.85rem',
                                fontWeight: 800,
                            }"
                        >
                            <i class="fa-solid fa-chair"></i>
                            <span>
                                {{
                                    orderType === "dinein"
                                        ? "T" + (currentTable || "—")
                                        : "T—"
                                }}
                            </span>
                        </button>
                        <span class="tools-sep" aria-hidden="true"></span>

                        <!-- User / Auth -->
                        <div class="ms-2 d-flex align-items-center gap-2">
                            <template v-if="isAuthed">
                                <span
                                    class="btn-pill d-inline-flex align-items-center gap-2"
                                >
                                    <i class="fa-solid fa-user-shield"></i>
                                    <span
                                        class="text-truncate"
                                        style="max-width: 160px"
                                    >
                                        {{
                                            authedUser?.name ||
                                            authedUser?.email ||
                                            "Staff"
                                        }}
                                    </span>
                                </span>

                                <button
                                    class="btn btn-danger-soft btn-sm"
                                    @click="logout"
                                    :disabled="authLoading"
                                >
                                    <i
                                        class="fa-solid fa-right-from-bracket me-1"
                                    ></i
                                    >Logout
                                </button>
                            </template>
                            <template v-else>
                                <span
                                    class="text-muted small d-none d-md-inline"
                                    >Not signed in</span
                                >
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== POS shell ===== -->
        <div class="container-fluid pos-shell" :aria-hidden="!isAuthed">
            <!-- ===== Left: Catalog ===== -->
            <section class="panel">
                <div class="panel-head">
                    <!-- 1) Order Type -->
                    <div class="choice-cards" id="orderTypeCards">
                        <button
                            type="button"
                            class="choice-card"
                            :class="{ active: orderType === 'dinein' }"
                            data-type="dinein"
                            @click="setOrderType('dinein')"
                        >
                            <div class="choice-ico">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div>
                                <div class="choice-label">Dine-in</div>
                                <small class="text-muted"
                                    >Assign to a table</small
                                >
                            </div>
                        </button>
                        <button
                            type="button"
                            class="choice-card"
                            :class="{ active: orderType === 'takeaway' }"
                            data-type="takeaway"
                            @click="setOrderType('takeaway')"
                        >
                            <div class="choice-ico">
                                <i class="fa-solid fa-bag-shopping"></i>
                            </div>
                            <div>
                                <div class="choice-label">Takeaway</div>
                                <small class="text-muted">Pack & go</small>
                            </div>
                        </button>
                        <button
                            type="button"
                            class="choice-card"
                            :class="{ active: orderType === 'delivery' }"
                            data-type="delivery"
                            @click="setOrderType('delivery')"
                        >
                            <div class="choice-ico">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <div>
                                <div class="choice-label">Delivery</div>
                                <small class="text-muted"
                                    >Send to address</small
                                >
                            </div>
                        </button>
                    </div>

                    <!-- 2) Search + QR -->
                    <!-- 2) Search + QR -->
                    <div class="search-row">
                        <input
                            id="posSearch"
                            type="search"
                            class="pos-search"
                            placeholder="Search items…"
                            aria-label="Search items…"
                            v-model.trim="searchQueryRaw"
                            @input="debouncedSearch"
                            :readonly="isTouch"
                            :inputmode="isTouch ? 'none' : null"
                            @focus="isTouch && (showSearchKb = true)"
                        />

                        <div class="import-wrap">
                            <button
                                class="btn btn-sub"
                                id="scanCode"
                                title="Scan QR"
                                @click="openScan()"
                            >
                                <i class="fa-solid fa-qrcode"></i>
                            </button>

                            <!-- ⌨️ toggle -->
                            <button
                                class="btn btn-sub"
                                title="Keyboard"
                                @click="showSearchKb = !showSearchKb"
                                aria-controls="searchKb"
                                :aria-expanded="showSearchKb ? 'true' : 'false'"
                            >
                                <i class="fa-solid fa-keyboard"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Keyboard tray -->
                    <SearchKeyboard
                        id="searchKb"
                        v-if="showSearchKb"
                        v-model="searchQueryRaw"
                        :rtl="isRTL"
                        @update:modelValue="handleKbInput"
                        @enter="submitSearch"
                        @close="showSearchKb = false"
                    />

                    <!-- 3) Categories (white card buttons) -->
                    <div class="categories-scroll cats-list" id="catPills">
                        <!-- All -->
                        <button
                            class="cat-btn"
                            :class="{ active: activeCat === '__all' }"
                            @click="setCat('__all')"
                            :aria-pressed="activeCat === '__all'"
                        >
                            <div class="cat-avatar">
                                <img
                                    v-if="categoryThumb(null)"
                                    :src="categoryThumb(null)"
                                    alt="All"
                                />
                                <div v-else class="cat-fallback">
                                    {{ iconForCategory("All") }}
                                </div>
                            </div>
                            <div class="cat-text">
                                <span class="cat-name">All</span>
                                <small
                                    class="cat-count"
                                    v-if="totalItemsCount"
                                    >{{ totalItemsCount }}</small
                                >
                            </div>
                        </button>

                        <!-- Each category -->
                        <button
                            v-for="cat in normalizedCategories"
                            :key="cat.slug"
                            class="cat-btn"
                            :class="{ active: activeCat === cat.slug }"
                            @click="setCat(cat.slug)"
                            :aria-pressed="activeCat === cat.slug"
                            :title="cat.name"
                        >
                            <div class="cat-avatar">
                                <img
                                    v-if="categoryThumb(cat)"
                                    :src="categoryThumb(cat)"
                                    :alt="cat.name"
                                />
                                <div v-else class="cat-fallback">
                                    {{ iconForCategory(cat.name) }}
                                </div>
                            </div>
                            <div class="cat-text">
                                <span class="cat-name text-truncate">{{
                                    cat.name
                                }}</span>
                                <small
                                    class="cat-count"
                                    v-if="catCounts[cat.slug]"
                                    >{{ catCounts[cat.slug] }}</small
                                >
                            </div>
                        </button>
                    </div>
                </div>

                <div class="panel-body">
                    <!-- Items grid -->
                    <div class="items-grid" id="itemsGrid">
                        <template v-if="normalizedItems.length">
                            <div
                                v-for="item in filteredItems"
                                :key="item.id || item.name + '-' + item.base"
                                class="item-card"
                                :data-cat="slug(item.categoryName)"
                                @click="openItem(item)"
                            >
                                <div class="item-thumb">
                                    <img
                                        loading="lazy"
                                        :src="item.image || placeholder"
                                        :alt="item.name"
                                    />
                                </div>
                                <div class="item-meta">
                                    <h5
                                        class="text-truncate"
                                        :title="item.name"
                                    >
                                        {{ item.name }}
                                    </h5>
                                    <div
                                        class="d-flex align-items-center justify-content-end"
                                    >
                                        <div class="price-tag">
                                            {{ money(item.base) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="!filteredItems.length"
                                class="text-muted"
                            >
                                No items match your search.
                            </div>
                        </template>
                        <template v-else>
                            <!-- Skeletons while loading -->
                            <div
                                v-for="i in 12"
                                :key="'sk' + i"
                                class="item-card skeleton"
                            ></div>
                        </template>
                    </div>
                </div>
            </section>

            <!-- ===== Right: Cart / Totals ===== -->
            <aside class="panel cart">
                <div class="cart-head">
                    <div class="cart-title">
                        <span class="cart-title-ico">
                            <i
                                class="fa-solid fa-basket-shopping"
                                aria-hidden="true"
                            ></i>
                        </span>
                        <span class="cart-title-text">Current Order</span>
                    </div>

                    <div class="cart-actions">
                        <button
                            class="btn-ctl"
                            id="holdOrder"
                            @click="holdOrder"
                            :disabled="saving || !isAuthed"
                        >
                            <i class="fa-solid fa-box-archive me-1"></i> Hold
                        </button>

                        <button
                            class="btn-ctl danger"
                            id="clearCart"
                            @click="clearCart"
                            :disabled="saving || !isAuthed"
                        >
                            <i class="fa-solid fa-trash-can me-1"></i> Clear
                        </button>

                        <button
                            class="btn-ctl"
                            @click="showHeldModal = true"
                            :disabled="saving || !isAuthed"
                            title="View held orders"
                        >
                            <i class="fa-solid fa-clock-rotate-left me-1"></i>
                            Held
                            <span class="count" aria-live="polite">{{
                                parkedOrders.length
                            }}</span>
                        </button>
                    </div>
                </div>

                <div class="cart-body" id="cartLines">
                    <div
                        v-for="(ln, idx) in cartLines"
                        :key="ln.id"
                        class="cart-line"
                    >
                        <div>
                            <h6>{{ ln.name }}</h6>
                            <div
                                v-for="(v, i) in ln.selections"
                                :key="i"
                                class="opts"
                            >
                                <small>
                                    {{ v.name }}:
                                    {{
                                        v.options
                                            .map(
                                                (o) =>
                                                    o.name +
                                                    (o.adj
                                                        ? ` (+${Number(
                                                              o.adj
                                                          ).toFixed(
                                                              2
                                                          )}${currency})`
                                                        : "")
                                            )
                                            .join(", ")
                                    }}
                                </small>
                            </div>
                            <div class="text-muted small">
                                Unit: {{ money(ln.unit) }}
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="qty-ctrl mb-1">
                                <button
                                    @click="decQty(idx)"
                                    :disabled="saving || !isAuthed"
                                >
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                                <span>{{ ln.qty }}</span>
                                <button
                                    @click="incQty(idx)"
                                    :disabled="saving || !isAuthed"
                                >
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                            <div class="line-total">
                                {{ money(ln.unit * ln.qty) }}
                            </div>
                            <button
                                class="btn btn-link text-danger p-0 small"
                                @click="rmLine(idx)"
                                :disabled="saving || !isAuthed"
                            >
                                Remove
                            </button>
                        </div>
                    </div>

                    <div v-if="!cartLines.length" class="text-muted">
                        Cart is empty.
                    </div>
                </div>

                <div class="cart-foot mt-5">
                    <div class="tot-row">
                        <span>Subtotal</span
                        ><strong id="t_sub">{{ money(subtotal) }}</strong>
                    </div>

                    <div class="tot-row align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span>Discount</span>
                            <div
                                class="btn-group btn-group-sm"
                                role="group"
                                aria-label="Discount type"
                                id="discType"
                            >
                                <input
                                    type="radio"
                                    class="btn-check"
                                    id="discAmt"
                                    autocomplete="off"
                                    value="amount"
                                    v-model="discountType"
                                />
                                <label
                                    class="btn btn-outline-secondary"
                                    for="discAmt"
                                    >Amount</label
                                >
                                <input
                                    type="radio"
                                    class="btn-check"
                                    id="discPct"
                                    autocomplete="off"
                                    value="percent"
                                    v-model="discountType"
                                />
                                <label
                                    class="btn btn-outline-secondary"
                                    for="discPct"
                                    >%</label
                                >
                            </div>
                        </div>
                        <div>
                            <input
                                id="discVal"
                                type="number"
                                class="form-control form-control-sm"
                                step="0.01"
                                v-model.number="discountValue"
                                style="width: 110px; text-align: right"
                                :aria-describedby="'discType'"
                                :disabled="saving || !isAuthed"
                            />
                        </div>
                    </div>

                    <div class="tot-row grand" aria-live="polite">
                        <span>Grand Total</span
                        ><span id="t_grand">{{ money(grandTotal) }}</span>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button
                            class="btn-main"
                            id="checkoutBtn"
                            :disabled="!cartLines.length || saving || !isAuthed"
                            @click="openPay()"
                        >
                            <i class="fa-solid fa-cash-register me-1"></i>
                            {{ saving ? "Saving…" : "Charge Payment" }}
                        </button>
                        <small class="text-muted"
                            >All prices in {{ currency.trim() }}</small
                        >
                    </div>

                    <!-- Parked orders -->
                    <div class="parked" v-if="false">
                        <div class="fw-bold mb-2">
                            <i class="fa-solid fa-clock-rotate-left me-1"></i
                            >Held Orders
                        </div>
                        <div id="parkedList">
                            <div
                                v-for="(o, i) in parkedOrders"
                                :key="o.id + '-' + o.time"
                                class="order-chip"
                                :class="{
                                    'is-loaded':
                                        activeParkedKey === (o._key || o.time),
                                }"
                            >
                                <div>
                                    <div class="fw-bold">
                                        #{{ o.id }} •
                                        {{ (o.type || "").toUpperCase() }}
                                        <span v-if="o.table">
                                            • T{{ o.table }}</span
                                        >
                                        <span
                                            v-if="
                                                activeParkedKey ===
                                                (o._key || o.time)
                                            "
                                            class="badge-pill ms-1"
                                            >Loaded</span
                                        >
                                    </div>
                                    <div class="small text-muted">
                                        {{ new Date(o.time).toLocaleString() }}
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <!-- no amount here -->
                                    <button
                                        class="btn btn-sm btn-sub"
                                        @click="resumeParked(i)"
                                    >
                                        Load
                                    </button>
                                    <button
                                        class="btn btn-sm btn-danger-soft"
                                        @click="deleteParkedByKey(parkKey(o))"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <div
                                v-if="!parkedOrders.length"
                                class="text-muted small"
                            >
                                No held orders.
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <!-- ===== Item Config Modal ===== -->
        <div
            class="modal fade"
            :class="{ show: showCfgModal }"
            style="display: block"
            v-if="showCfgModal"
            tabindex="-1"
            aria-modal="true"
            role="dialog"
            @click.self="closeCfg()"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl cfg-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold m-0">
                            {{ cfgItem.name }}
                        </h6>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeCfg()"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <div class="cfg-grid">
                            <!-- Left: image -->
                            <aside class="cfg-left">
                                <div class="media-wrap">
                                    <img
                                        id="cfgImg"
                                        :src="cfgItem.img || placeholder"
                                        alt=""
                                    />
                                </div>
                            </aside>

                            <!-- Right: info + options -->
                            <section class="cfg-right">
                                <!-- Info -->
                                <div class="info-card">
                                    <p
                                        id="cfgDesc"
                                        class="mb-2 small text-muted"
                                        v-if="cfgItem.desc"
                                    >
                                        {{ cfgItem.desc }}
                                    </p>
                                    <h5 id="cfgPrice" class="cfg-price mb-2">
                                        {{ money(cfgUnitPrice) }}
                                    </h5>

                                    <div
                                        class="d-flex align-items-center justify-content-between"
                                    >
                                        <div class="qty-wrap">
                                            <button
                                                class="qty-btn"
                                                id="cfgMinus"
                                                @click="decCfgQty"
                                            >
                                                <i
                                                    class="fa-solid fa-minus"
                                                ></i>
                                            </button>
                                            <input
                                                id="cfgQty"
                                                class="qty-input"
                                                type="number"
                                                :min="cfgItem.minq || 1"
                                                :max="cfgItem.maxq || null"
                                                step="1"
                                                v-model.number="cfgItem.qty"
                                            />
                                            <button
                                                class="qty-btn"
                                                id="cfgPlus"
                                                @click="incCfgQty"
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        </div>
                                        <div
                                            class="req-hint"
                                            id="cfgReq"
                                            v-show="!cfgValid"
                                        >
                                            Please complete required selections.
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-2">
                                        <button
                                            id="cfgAdd"
                                            class="btn-main"
                                            :disabled="!cfgValid"
                                            @click="addToCart"
                                        >
                                            <i
                                                class="fa-solid fa-cart-plus me-1"
                                            ></i
                                            >Add to Order
                                        </button>
                                    </div>
                                </div>

                                <!-- Options: full width; two choices per row -->
                                <div class="opts-card">
                                    <!-- Single-select -->
                                    <div
                                        class="v-group group-card"
                                        v-for="(v, gi) in cfgSingles"
                                        :key="'s' + (v.id || gi)"
                                        :data-vid="v.id || gi"
                                    >
                                        <div class="v-title-row">
                                            <div
                                                class="v-title"
                                                v-html="
                                                    v.name +
                                                    (minSel(v) > 0
                                                        ? ' <span class=&quot;text-danger&quot;>*</span>'
                                                        : '')
                                                "
                                            ></div>
                                            <button
                                                v-if="
                                                    vSingle(v) &&
                                                    minSel(v) === 0 &&
                                                    selectedCount(v) > 0
                                                "
                                                class="btn-clear-group"
                                                type="button"
                                                @click="clearGroup(v)"
                                            >
                                                Clear
                                            </button>
                                        </div>

                                        <div class="options-grid two-cols">
                                            <label
                                                v-for="(o, oi) in v.options ||
                                                []"
                                                :key="o.id || oi"
                                                class="option-card"
                                                :class="{
                                                    disabled:
                                                        String(
                                                            o.is_available
                                                        ) === '0',
                                                    selected: isOptionSelected(
                                                        v,
                                                        o
                                                    ),
                                                }"
                                            >
                                                <input
                                                    class="option-input"
                                                    type="radio"
                                                    :name="
                                                        'var_' + (v.id || gi)
                                                    "
                                                    :value="o.id || oi"
                                                    :disabled="
                                                        String(
                                                            o.is_available
                                                        ) === '0'
                                                    "
                                                    :checked="
                                                        isOptionSelected(v, o)
                                                    "
                                                    @change="toggleOption(v, o)"
                                                />
                                                <div class="option-inner">
                                                    <i
                                                        class="fa-solid fa-check sel-check"
                                                        aria-hidden="true"
                                                    ></i>
                                                    <div class="option-name">
                                                        {{ o.name }}
                                                    </div>
                                                    <div
                                                        class="option-badge"
                                                        :class="{
                                                            'is-zero': !adj(o),
                                                        }"
                                                    >
                                                        <template v-if="adj(o)"
                                                            >+{{
                                                                money(adj(o))
                                                            }}</template
                                                        >
                                                        <template v-else
                                                            >Included</template
                                                        >
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Multi-select -->
                                    <div
                                        class="v-group group-card"
                                        v-for="(v, gi) in cfgMultis"
                                        :key="'m' + (v.id || gi)"
                                        :data-vid="v.id || gi"
                                    >
                                        <div class="v-title-row">
                                            <div
                                                class="v-title"
                                                v-html="
                                                    v.name +
                                                    (minSel(v) > 0
                                                        ? ' <span class=&quot;text-danger&quot;>*</span>'
                                                        : '')
                                                "
                                            ></div>
                                        </div>

                                        <div class="options-grid two-cols">
                                            <label
                                                v-for="(o, oi) in v.options ||
                                                []"
                                                :key="o.id || oi"
                                                class="option-card"
                                                :class="{
                                                    disabled:
                                                        String(
                                                            o.is_available
                                                        ) === '0',
                                                    selected: isOptionSelected(
                                                        v,
                                                        o
                                                    ),
                                                }"
                                            >
                                                <input
                                                    class="option-input"
                                                    type="checkbox"
                                                    :name="
                                                        'var_' + (v.id || gi)
                                                    "
                                                    :value="o.id || oi"
                                                    :disabled="
                                                        String(
                                                            o.is_available
                                                        ) === '0'
                                                    "
                                                    :checked="
                                                        isOptionSelected(v, o)
                                                    "
                                                    @change="toggleOption(v, o)"
                                                />
                                                <div class="option-inner">
                                                    <i
                                                        class="fa-solid fa-check sel-check"
                                                        aria-hidden="true"
                                                    ></i>
                                                    <div class="option-name">
                                                        {{ o.name }}
                                                    </div>
                                                    <div
                                                        class="option-badge"
                                                        :class="{
                                                            'is-zero': !adj(o),
                                                        }"
                                                    >
                                                        <template v-if="adj(o)"
                                                            >+{{
                                                                money(adj(o))
                                                            }}</template
                                                        >
                                                        <template v-else
                                                            >Included</template
                                                        >
                                                    </div>
                                                </div>
                                            </label>
                                        </div>

                                        <div class="option-hint">
                                            You can select up to
                                            {{ maxSel(v) }} option(s)
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="showCfgModal"
            class="modal-backdrop fade show"
            @click="closeCfg()"
        ></div>

        <!-- ===== Payment Modal ===== -->
        <div
            class="modal fade"
            :class="{ show: showPayModal }"
            style="display: block"
            v-if="showPayModal"
            tabindex="-1"
            aria-modal="true"
            role="dialog"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-cash-register me-2"></i>Take
                            Payment
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closePay()"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div
                            class="mb-2 d-flex align-items-center justify-content-between"
                        >
                            <div>
                                Grand Total:
                                <strong id="payTotal">{{
                                    money(grandTotal)
                                }}</strong>
                            </div>
                            <div
                                class="daily-chip"
                                v-if="nextDailyOrderPreview"
                            >
                                Ticket #:
                                <strong>{{ nextDailyOrderPreview }}</strong>
                            </div>
                        </div>

                        <!-- Simple method pills -->
                        <div class="pay-methods d-flex gap-2 mb-2">
                            <button
                                class="btn btn-sm"
                                :class="{ active: payMethod === 'cash' }"
                                @click="payMethod = 'cash'"
                            >
                                <i class="fa-solid fa-money-bill-wave me-1"></i
                                >Cash
                            </button>
                            <button
                                class="btn btn-sm"
                                :class="{ active: payMethod === 'card' }"
                                @click="payMethod = 'card'"
                            >
                                <i class="fa-solid fa-credit-card me-1"></i>Card
                            </button>
                            <button
                                class="btn btn-sm"
                                :class="{ active: payMethod === 'other' }"
                                @click="payMethod = 'other'"
                            >
                                <i class="fa-solid fa-wallet me-1"></i>Other
                            </button>
                            <button
                                class="btn btn-sm btn-sub"
                                @click="addPayPart()"
                                title="Add split payment"
                            >
                                <i class="fa-solid fa-plus me-1"></i>Split
                            </button>
                        </div>

                        <!-- Split payment table -->
                        <div v-if="payParts.length" class="mb-2">
                            <table class="table table-sm align-middle">
                                <thead class="text-muted">
                                    <tr>
                                        <th>Method</th>
                                        <th class="text-end">Amount</th>
                                        <th class="text-end"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(p, i) in payParts"
                                        :key="'pp' + i"
                                    >
                                        <td class="text-uppercase">
                                            <select
                                                class="form-select form-select-sm w-auto"
                                                v-model="p.method"
                                            >
                                                <option value="cash">
                                                    Cash
                                                </option>
                                                <option value="card">
                                                    Card
                                                </option>
                                                <option value="other">
                                                    Other
                                                </option>
                                            </select>
                                        </td>
                                        <td class="text-end">
                                            <input
                                                type="number"
                                                class="form-control form-control-sm text-end"
                                                step="0.01"
                                                v-model.number="p.amount"
                                            />
                                        </td>
                                        <td class="text-end">
                                            <button
                                                class="btn btn-danger-soft btn-sm"
                                                @click="payParts.splice(i, 1)"
                                            >
                                                <i
                                                    class="fa-solid fa-xmark"
                                                ></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Remaining</th>
                                        <th class="text-end">
                                            {{
                                                money(
                                                    Math.max(
                                                        0,
                                                        grandTotal -
                                                            payPartsTotal
                                                    )
                                                )
                                            }}
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Cash-only flow -->
                        <div
                            v-if="!payParts.length"
                            class="row g-2 align-items-end"
                        >
                            <div class="col-12">
                                <div class="d-flex flex-wrap gap-2 my-2">
                                    <button
                                        class="btn btn-sm btn-sub"
                                        @click="quickCash(grandTotal)"
                                    >
                                        Exact
                                    </button>
                                    <button
                                        class="btn btn-sm btn-sub"
                                        @click="
                                            quickCash(
                                                Math.ceil(grandTotal / 10) * 10
                                            )
                                        "
                                    >
                                        Round 10
                                    </button>
                                    <button
                                        class="btn btn-sm btn-sub"
                                        v-for="v in [20, 50, 100, 200]"
                                        :key="v"
                                        @click="quickCash(v)"
                                    >
                                        {{ v.toFixed(0) }}{{ currency.trim() }}
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small"
                                    >Amount Tendered</label
                                >
                                <input
                                    id="payGiven"
                                    type="number"
                                    step="0.01"
                                    class="form-control"
                                    v-model.number="payGiven"
                                />
                            </div>
                            <div class="col-6">
                                <div class="change-box">
                                    <i class="fa-solid fa-coins me-1"></i
                                    >Change:
                                    <span id="payChange">{{
                                        money(changeDue)
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 d-grid gap-2">
                            <button
                                id="finalizePayment"
                                class="btn-main"
                                @click="finalize(true)"
                                :disabled="saving || !isAuthed"
                            >
                                <i class="fa-solid fa-check me-1"></i
                                >{{ saving ? "Saving…" : "Finalize & Print" }}
                            </button>
                            <button
                                id="finalizeNoPrint"
                                class="btn-sub"
                                @click="finalize(false)"
                                :disabled="saving || !isAuthed"
                            >
                                <i class="fa-solid fa-check me-1"></i
                                >{{
                                    saving ? "Saving…" : "Finalize (No Print)"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="showPayModal"
            class="modal-backdrop fade show"
            @click="closePay()"
        ></div>

        <!-- ===== Scanner Modal ===== -->
        <div
            class="modal fade"
            :class="{ show: showScanModal }"
            style="display: block"
            v-if="showScanModal"
            tabindex="-1"
            aria-modal="true"
            role="dialog"
        >
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-qrcode me-2"></i>Scan Client
                            QR
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="closeScan()"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-muted small mb-2">
                            When detected, items will be added to the current
                            order automatically.
                        </div>
                        <div id="qrReader"></div>
                        <div v-if="!qrAvailable" class="text-danger small mt-2">
                            Scanner failed to load. (Ensure html5-qrcode is
                            included)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="showScanModal"
            class="modal-backdrop fade show"
            @click="closeScan()"
        ></div>
        <!-- ===== Held Orders Modal ===== -->
        <!-- ===== Held Orders Modal (enhanced) ===== -->
        <div
            class="modal fade held-modal"
            :class="{ show: showHeldModal }"
            style="display: block"
            v-if="showHeldModal"
            tabindex="-1"
            aria-modal="true"
            role="dialog"
            @click.self="showHeldModal = false"
        >
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content held-modal-content">
                    <div class="modal-header held-modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <i class="fa-solid fa-box-archive"></i>
                            Held Orders
                            <span class="badge-pill held-count ms-1">{{
                                filteredHeld.length
                            }}</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="showHeldModal = false"
                            aria-label="Close"
                        ></button>
                    </div>

                    <div class="modal-body">
                        <!-- Search row -->
                        <div class="held-toolbar">
                            <div class="held-search">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input
                                    class="held-search-input"
                                    placeholder="Search by type, table or item name…"
                                    v-model.trim="heldQuery"
                                    aria-label="Search held orders"
                                />
                            </div>

                            <div class="held-legend">
                                <span class="legend-dot legend-loaded"></span>
                                Loaded
                                <span class="legend-sep">•</span>
                                <span class="legend-dot legend-dinein"></span>
                                Dine-in
                                <span class="legend-sep">•</span>
                                <span class="legend-dot legend-other"></span>
                                Other types
                            </div>
                        </div>

                        <!-- Empty state -->
                        <div v-if="!filteredHeld.length" class="held-empty">
                            <div class="held-empty-icon">
                                <i class="fa-regular fa-clock"></i>
                            </div>
                            <div class="held-empty-title">No held orders</div>
                            <div class="held-empty-sub">
                                Use “Hold” to park the current order.
                            </div>
                        </div>

                        <!-- Cards grid (max 2 per row) -->
                        <div class="held-grid-modern" v-else>
                            <div
                                v-for="o in filteredHeld"
                                :key="o._key || o.time"
                                class="held-card-modern"
                                :class="[
                                    (o.type || '') === 'dinein'
                                        ? 'is-dinein'
                                        : 'is-other',
                                    activeParkedKey === (o._key || o.time)
                                        ? 'is-loaded'
                                        : '',
                                ]"
                                role="button"
                                tabindex="0"
                                @click="resumeParkedByKey(parkKey(o))"
                                @keydown.enter.prevent="
                                    resumeParkedByKey(parkKey(o))
                                "
                                @keydown.space.prevent="
                                    resumeParkedByKey(parkKey(o))
                                "
                                :aria-label="`Load held order #${o.id || ''}`"
                            >
                                <!-- top row -->
                                <div class="held-card-top">
                                    <div class="held-id">#{{ o.id }}</div>
                                    <div class="held-type">
                                        <span class="chip-type">
                                            {{ (o.type || "").toUpperCase() }}
                                            <span v-if="o.table"
                                                >• T{{ o.table }}</span
                                            >
                                        </span>
                                        <span
                                            v-if="
                                                activeParkedKey ===
                                                (o._key || o.time)
                                            "
                                            class="chip-loaded"
                                            >Loaded</span
                                        >
                                    </div>
                                </div>

                                <!-- meta -->
                                <div class="held-meta small">
                                    <span class="meta-dot">
                                        <i class="fa-regular fa-clock"></i>
                                        {{
                                            new Date(
                                                o.time
                                            ).toLocaleTimeString()
                                        }}
                                    </span>
                                    <span class="meta-dot">{{
                                        timeAgo(o.time)
                                    }}</span>
                                    <span class="meta-dot">
                                        <i class="fa-solid fa-layer-group"></i>
                                        {{ itemsCount(o) }} item(s)
                                    </span>
                                </div>

                                <!-- items -->
                                <ul class="held-items">
                                    <li
                                        v-for="(ln, idx) in o.lines"
                                        :key="idx"
                                        class="held-item"
                                    >
                                        <!-- top row: name (left) + quantity (right) -->
                                        <div class="held-line-main">
                                            <span
                                                class="held-item-name text-truncate"
                                                >{{ ln.name }}</span
                                            >
                                            <span class="held-item-qty"
                                                >× {{ ln.qty }}</span
                                            >
                                        </div>

                                        <!-- options block: FULL WIDTH under the name -->
                                        <div
                                            v-if="
                                                ln.selections &&
                                                ln.selections.length
                                            "
                                            class="held-item-opts"
                                        >
                                            <div
                                                v-for="(
                                                    sel, si
                                                ) in ln.selections"
                                                :key="si"
                                                class="held-opt-group"
                                            >
                                                <span class="held-opt-label"
                                                    >{{ sel.name }}:</span
                                                >
                                                <span class="held-opt-values">
                                                    <span
                                                        v-for="(
                                                            op, oi
                                                        ) in sel.options || []"
                                                        :key="oi"
                                                        class="held-val"
                                                    >
                                                        {{
                                                            op.name ||
                                                            op.option_name
                                                        }}
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <!-- actions -->
                                <div class="held-actions-modern">
                                    <button
                                        class="btn btn-danger-soft btn-sm"
                                        title="Delete held order"
                                        @click.stop="
                                            deleteParkedByKey(parkKey(o))
                                        "
                                    >
                                        <i
                                            class="fa-solid fa-trash-can me-1"
                                        ></i
                                        >Delete
                                    </button>
                                    <div class="ghost-spacer"></div>
                                    <div class="cta-hint">
                                        <span>Click to load</span>
                                        <i
                                            class="fa-solid fa-arrow-right-long"
                                        ></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer held-modal-footer">
                        <button
                            class="btn btn-sub"
                            @click="showHeldModal = false"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="showHeldModal"
            class="modal-backdrop fade show"
            @click="showHeldModal = false"
        ></div>

        <!-- ===== Offcanvas: Tables ===== -->
        <div
            class="offcanvas offcanvas-end"
            :class="{ show: showTables }"
            tabindex="-1"
            id="tablesCanvas"
            style="visibility: visible"
            v-if="showTables"
            aria-modal="true"
            role="dialog"
        >
            <div class="offcanvas-header">
                <h5 id="tablesCanvasLabel">
                    <i class="fa-solid fa-chair me-2"></i>Select Table
                </h5>
            </div>
            <div class="offcanvas-body">
                <div
                    id="tablesNotice"
                    class="alert alert-warning py-2 px-3"
                    :class="{ 'd-none': orderType === 'dinein' }"
                >
                    <i class="fa-solid fa-circle-info me-1"></i>
                    Tables can be assigned for Dine-in orders only.
                </div>

                <input
                    class="form-control form-control-sm mb-2"
                    placeholder="Search table…"
                    v-model.trim="tableSearch"
                />

                <div class="table-grid" id="tablesGrid">
                    <div
                        v-for="i in 20"
                        :key="i"
                        class="table-card"
                        v-show="String(i).includes(tableSearch)"
                        :class="{
                            active: String(currentTable) === String(i),
                            disabled:
                                disabledTables.has(String(i)) &&
                                String(currentTable) !== String(i),
                        }"
                        :tabindex="
                            orderType === 'dinein' &&
                            !(
                                disabledTables.has(String(i)) &&
                                String(currentTable) !== String(i)
                            )
                                ? 0
                                : -1
                        "
                        :style="{
                            opacity: orderType === 'dinein' ? 1 : 0.5,
                            pointerEvents:
                                orderType === 'dinein' &&
                                !(
                                    disabledTables.has(String(i)) &&
                                    String(currentTable) !== String(i)
                                )
                                    ? 'auto'
                                    : 'none',
                        }"
                        role="button"
                        :aria-label="'Table ' + i"
                        @click="selectTable(i)"
                        @keydown.enter.prevent="selectTable(i)"
                        @keydown.space.prevent="selectTable(i)"
                    >
                        <div class="table-ico">
                            <i class="fa-solid fa-chair"></i>
                        </div>
                        <div class="fw-bold">Table #{{ i }}</div>
                        <small class="text-muted">
                            {{
                                String(currentTable) === String(i)
                                    ? "Selected"
                                    : disabledTables.has(String(i))
                                    ? "Held"
                                    : "Available"
                            }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="showTables"
            class="offcanvas-backdrop fade show"
            @click="closeTables()"
        ></div>

        <!-- ===== FULLSCREEN AUTH OVERLAY ===== -->
        <div
            class="auth-overlay"
            v-if="!authReady || !isAuthed"
            aria-modal="true"
            role="dialog"
        >
            <div class="auth-card">
                <div class="text-center mb-2">
                    <img
                        :src="logoSrc"
                        alt="Logo"
                        style="width: 56px; height: 56px; border-radius: 50%"
                    />
                </div>
                <h4 class="mb-1 text-center">
                    {{ restaurantName }} <small class="text-muted">POS</small>
                </h4>

                <div v-if="!authReady" class="text-center py-3">
                    <i class="fa-solid fa-spinner fa-spin"></i> Checking
                    session…
                </div>

                <form v-else @submit.prevent="login">
                    <!-- Staff Code (compact, code-only tiles) -->
                    <div class="mb-3">
                        <label
                            class="form-label small d-flex align-items-center justify-content-between"
                        >
                            <span>Staff Code</span>
                            <small class="text-muted" v-if="loginForm.code">
                                {{ isRTL ? "المحدد:" : "Selected:" }} #{{
                                    loginForm.code
                                }}
                            </small>
                        </label>

                        <div
                            class="staff-grid-compact"
                            role="listbox"
                            aria-label="Staff list"
                        >
                            <button
                                v-for="u in users"
                                :key="u.pos_code"
                                type="button"
                                role="option"
                                class="staff-code-card"
                                :class="{
                                    active:
                                        String(loginForm.code) ===
                                        String(u.pos_code),
                                    'is-disabled': !!u.is_disabled,
                                }"
                                :aria-selected="
                                    String(loginForm.code) ===
                                    String(u.pos_code)
                                        ? 'true'
                                        : 'false'
                                "
                                :disabled="authLoading || !!u.is_disabled"
                                @click="loginForm.code = String(u.pos_code)"
                                :title="'#' + u.pos_code"
                            >
                                <span class="code-label"
                                    >#{{ u.pos_code }}</span
                                >
                            </button>

                            <div
                                v-if="!users || !users.length"
                                class="staff-empty text-muted"
                            >
                                {{
                                    isRTL
                                        ? "لا يوجد مستخدمون"
                                        : "No staff available"
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small">PIN</label>
                        <input
                            class="form-control"
                            type="password"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            v-model="loginForm.pin"
                            placeholder="••••"
                            autocomplete="current-password"
                            :disabled="authLoading"
                            required
                        />
                    </div>

                    <!-- Optional quick keypad -->
                    <div class="pin-grid" aria-hidden="true">
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('1')"
                            :disabled="authLoading"
                        >
                            1
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('2')"
                            :disabled="authLoading"
                        >
                            2
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('3')"
                            :disabled="authLoading"
                        >
                            3
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('4')"
                            :disabled="authLoading"
                        >
                            4
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('5')"
                            :disabled="authLoading"
                        >
                            5
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('6')"
                            :disabled="authLoading"
                        >
                            6
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('7')"
                            :disabled="authLoading"
                        >
                            7
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('8')"
                            :disabled="authLoading"
                        >
                            8
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('9')"
                            :disabled="authLoading"
                        >
                            9
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="backspacePin()"
                            :disabled="authLoading"
                        >
                            <i class="fa-solid fa-delete-left"></i>
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="appendPin('0')"
                            :disabled="authLoading"
                        >
                            0
                        </button>
                        <button
                            type="button"
                            class="pin-key"
                            @click="clearPin()"
                            :disabled="authLoading"
                        >
                            Clear
                        </button>
                    </div>

                    <div
                        v-if="loginError"
                        class="alert alert-danger py-2 px-3 mt-2"
                    >
                        {{ loginError }}
                    </div>

                    <div class="d-grid mt-3">
                        <button
                            type="submit"
                            class="btn-main"
                            :disabled="authLoading"
                        >
                            <i class="fa-solid fa-right-to-bracket me-1"></i>
                            {{ authLoading ? "Signing in…" : "Sign in" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Toast host -->
        <div
            id="toast"
            class="toast-pos"
            aria-live="polite"
            aria-atomic="true"
        ></div>
    </div>
</template>

<script>
import SearchKeyboard from "./SearchKeyboard.vue";

export default {
    name: "PosView",
    props: {
        restaurant: { type: Object, default: () => ({}) },
        articles: { type: Array, default: () => [] },
        categories: { type: Array, default: () => [] },
        languages: { type: Array, default: () => [] },
        defaultLanguage: { type: String, default: "en" },
        currency: { type: String, default: " DH" },
        placeholder: {
            type: String,
            default: "/assets/img/gallery/placeholder.png",
        },
        users: { type: Array, default: () => [] },
        logoFallback: { type: String, default: "/assets/img/logo/logo.svg" },
        ordersEndpoint: { type: String, default: "/api/orders" },
        loginEndpoint: { type: String, default: "/api/pos/login" },
        meEndpoint: { type: String, default: "/api/pos/me" },
        logoutEndpoint: { type: String, default: "/api/pos/logout" },
    },
    components: {
        SearchKeyboard,
    },
    data() {
        return {
            activeParkedKey: null, // which hold is currently loaded into the cart
            showHeldModal: false, // modal visibility
            heldQuery: "", // modal search

            showSearchKb: false,
            isTouch: false,

            language: this.defaultLanguage || "en",
            orderType: "dinein",
            currentTable: null,
            activeCat: "__all",
            searchQueryRaw: "",
            searchQuery: "",
            _searchT: null,

            cartLines: [],
            discountType: "amount",
            discountValue: 0,

            saving: false,
            numberFmt: null,

            showCfgModal: false,
            cfgItem: {
                name: "",
                desc: "",
                img: "",
                base: 0,
                qty: 1,
                minq: 1,
                maxq: null,
                variations: [],
                catalog_item_id: null,
                catalog_category_id: null,
                category_name: null,
                preparation_time: null,
            },

            showPayModal: false,
            payMethod: "cash",
            payGiven: 0,
            payParts: [],
            nextDailyOrderPreview: null,

            showScanModal: false,
            qrScanner: null,
            qrAvailable: false,

            showTables: false,
            tableSearch: "",

            storageScope: null,
            parkedOrders: [],
            pendingOrders: [],
            authToken: localStorage.getItem("pos_token") || null,
            authReady: false,
            authLoading: false,
            authedUser: null,
            loginForm: { code: "", pin: "" },
            loginError: "",
        };
    },
    computed: {
        disabledTables() {
            const set = new Set();
            if (this.currentTable != null) set.add(String(this.currentTable));
            (this.parkedOrders || []).forEach((o) => {
                if ((o.type || "") === "dinein" && o.table != null) {
                    set.add(String(o.table));
                }
            });
            return set;
        },
        filteredHeld() {
            const q = (this.heldQuery || "").toLowerCase().trim();
            const list = (this.parkedOrders || [])
                .slice()
                .sort((a, b) => Number(a.time || 0) - Number(b.time || 0));
            if (!q) return list;
            return list.filter((o) => {
                const type = String(o.type || "").toLowerCase();
                const table = String(o.table || "");
                const items = (o.lines || [])
                    .map((l) => String(l.name || "").toLowerCase())
                    .join(" ");
                return (
                    type.includes(q) || table.includes(q) || items.includes(q)
                );
            });
        },

        totalItemsCount() {
            return this.normalizedItems.length || 0;
        },
        catCounts() {
            const map = {};
            this.normalizedItems.forEach((it) => {
                const s = this.slug(it.categoryName);
                map[s] = (map[s] || 0) + 1;
            });
            return map;
        },
        restaurantName() {
            return this.restaurant?.name || "Restaurant";
        },
        logoSrc() {
            return this.restaurant?.logo || this.logoFallback;
        },
        restaurantAddress() {
            return this.restaurant?.address || "";
        },
        tagline() {
            return (
                (this.restaurant?.settings &&
                    this.restaurant.settings.tagline) ||
                "Fresh • Local • Delicious"
            );
        },
        isRTL() {
            const code = (this.language || "").toLowerCase();
            return ["ar", "he", "fa", "ur"].includes(code);
        },
        isAuthed() {
            return !!this.authedUser;
        },

        catMeta() {
            // Build per-category {count, img} from items
            const meta = {};
            const touch = (slug, img) => {
                if (!meta[slug]) meta[slug] = { count: 0, img: "" };
                meta[slug].count++;
                if (!meta[slug].img && img) meta[slug].img = img; // first image as thumb
            };
            (this.normalizedItems || []).forEach((it) => {
                const slug = this.slug(it.categoryName);
                touch(slug, it.image);
                touch("__all", it.image);
            });
            return meta;
        },

        normalizedCategories() {
            // Prefer provided categories; fall back to categories derived from items
            const fromProps =
                Array.isArray(this.categories) && this.categories.length;
            const meta = this.catMeta;

            if (fromProps) {
                return this.categories.map((c, idx) => {
                    const name =
                        (c.current_translation && c.current_translation.name) ||
                        c.name ||
                        c.title ||
                        `Category ${idx + 1}`;
                    const slug =
                        typeof c.slug === "string" && c.slug.length
                            ? String(c.slug)
                            : this.slug(name);
                    const id = c.id ?? c.uuid ?? slug;
                    // try common image fields
                    const catImg =
                        c.image ||
                        c.photo ||
                        c.thumbnail ||
                        c.cover ||
                        meta[slug]?.img ||
                        "";
                    const count = meta[slug]?.count || 0;
                    return { id, name, slug, image: catImg, count };
                });
            }

            // derive from items if no prop
            const map = {};
            (this.articles || []).forEach((it) => {
                const c = it && it.category;
                const rawName =
                    (c &&
                        ((c.current_translation &&
                            c.current_translation.name) ||
                            c.name)) ||
                    null;
                if (rawName) {
                    const slug = this.slug(rawName);
                    if (!map[slug]) map[slug] = rawName;
                }
            });

            return Object.entries(map).map(([slug, name]) => ({
                id: slug,
                name,
                slug,
                image: meta[slug]?.img || "",
                count: meta[slug]?.count || 0,
            }));
        },

        normalizedItems() {
            return (this.articles || []).map((it) => {
                const name =
                    (it.current_translation && it.current_translation.name) ||
                    it.name ||
                    "Item";
                const desc =
                    (it.current_translation &&
                        it.current_translation.description) ||
                    "";
                const base =
                    parseFloat(
                        it.sale_price || it.current_price || it.price || 0
                    ) || 0;
                const image = it.image || "";
                const minq = it.min_qty || 1;
                const maxq = it.max_qty || null;
                const variations = it.variations || [];
                const categoryName =
                    (it.category &&
                        ((it.category.current_translation &&
                            it.category.current_translation.name) ||
                            it.category.name)) ||
                    "Uncategorized";
                return {
                    raw: it,
                    id: it.id || name,
                    name,
                    desc,
                    base,
                    image,
                    minq,
                    maxq,
                    variations,
                    categoryName,
                };
            });
        },
        filteredItems() {
            const q = (this.searchQuery || "").toLowerCase();
            return this.normalizedItems.filter((it) => {
                const catOk =
                    this.activeCat === "__all" ||
                    this.slug(it.categoryName) === this.activeCat;
                const text = (it.name + " " + it.desc).toLowerCase();
                const qOk = !q || text.includes(q);
                return catOk && qOk;
            });
        },
        subtotal() {
            return Number(
                this.cartLines
                    .reduce((a, c) => a + c.unit * c.qty, 0)
                    .toFixed(2)
            );
        },
        discountAmount() {
            const sub = this.subtotal;
            if (this.discountType === "percent") {
                const p = Math.min(
                    100,
                    Math.max(0, Number(this.discountValue || 0))
                );
                return Number(Math.min(sub, sub * (p / 100)).toFixed(2));
            }
            const amt = Math.max(0, Number(this.discountValue || 0));
            return Number(Math.min(sub, amt).toFixed(2));
        },
        grandTotal() {
            return Number(
                Math.max(0, this.subtotal - this.discountAmount).toFixed(2)
            );
        },
        payPartsTotal() {
            return this.payParts.reduce((a, c) => a + Number(c.amount || 0), 0);
        },
        changeDue() {
            const paid = this.payParts.length
                ? this.payPartsTotal
                : Number(this.payGiven || 0);
            return Number(Math.max(0, paid - this.grandTotal).toFixed(2));
        },
        cfgValid() {
            for (const v of this.cfgItem.variations || []) {
                const min = this.minSel(v);
                if (min > 0 && this.selectedCount(v) < min) return false;
            }
            return true;
        },
        cfgUnitPrice() {
            let unit = Number(this.cfgItem.base || 0);
            for (const v of this.cfgItem.variations || []) {
                for (const o of this.selectedOptions(v)) {
                    const a = this.adj(o);
                    if (a) unit += a;
                }
            }
            return unit;
        },

        cfgSingles() {
            return (this.cfgItem.variations || []).filter((v) => !!v._single);
        },
        cfgMultis() {
            return (this.cfgItem.variations || []).filter((v) => !v._single);
        },
    },
    mounted() {
        // theme + number format set-up (unchanged)
        document.documentElement.dataset.theme =
            localStorage.getItem("pos_theme") || "";

        const iso = this.isoCurrency();
        try {
            this.numberFmt = iso
                ? new Intl.NumberFormat(
                      this.isRTL ? "ar" : this.language || "en",
                      {
                          style: "currency",
                          currency: iso,
                          currencyDisplay: "symbol",
                          minimumFractionDigits: 2,
                      }
                  )
                : null;
        } catch (_) {
            this.numberFmt = null;
        }
        this.isTouch = "ontouchstart" in window || navigator.maxTouchPoints > 0;

        // 🔴 IMPORTANT: set the scope FIRST so all keys are consistent
        this.storageScope =
            this.restaurant?.id ?? this.slug(this.restaurantName) ?? "rest";

        // Auth init (unchanged)
        this.initAuth();

        // Load state with the CORRECT scope
        this.loadCartState();
        this.loadPendingOrders();

        // 1) Load parked orders for this scope
        this.parkedOrders = this.getParked();

        // 2) One-time migration from legacy keys if nothing found for this scope
        //    - use a per-scope guard so it won't run repeatedly
        const MIGRATED_FLAG = this.stateKey("pos_park_migrated");
        if (!this.parkedOrders.length && !localStorage.getItem(MIGRATED_FLAG)) {
            const candidates = [
                `pos_parked_orders:rest`,
                `pos_parked_orders:${this.slug("Restaurant")}`,
                // add other historic patterns here if you had any
            ];
            for (const k of candidates) {
                const raw = localStorage.getItem(k);
                if (raw && raw !== "[]" && raw.trim() !== "") {
                    try {
                        const arr = JSON.parse(raw);
                        if (Array.isArray(arr) && arr.length) {
                            // write into the new, stable scoped key and USE IT
                            this.setParked(arr);
                            this.parkedOrders = arr;

                            // ✅ mark migrated for this scope
                            localStorage.setItem(MIGRATED_FLAG, "1");

                            // ✅ purge legacy key so deleted orders can't resurrect later
                            localStorage.removeItem(k);
                            break;
                        }
                    } catch (_) {}
                }
            }
        }

        // 3) Now that parkedOrders is loaded, fix missing ids if any
        this.migrateHeldIds();
    },

    watch: {
        cartLines: {
            deep: true,
            handler() {
                this.saveCartState();
            },
        },
        discountType() {
            this.saveCartState();
        },
        discountValue() {
            this.saveCartState();
        },
        orderType() {
            this.saveCartState();
        },
        currentTable() {
            this.saveCartState();
        },
        payParts: {
            deep: true,
            handler() {
                this.saveCartState();
            },
        },
    },
    methods: {
        nextHoldNumber() {
            const arr = this.parkedOrders || [];
            if (!arr.length) return 1; // reinit to 1 when empty
            // choose the smallest positive integer not currently used to avoid collisions
            const used = new Set(arr.map((o) => Number(o.id || 0)));
            let n = 1;
            while (used.has(n)) n++;
            return n;
        },
        migrateHeldIds() {
            let changed = false;
            this.parkedOrders.forEach((o) => {
                if (!o.id) {
                    o.id = this.getNextHeldId();
                    changed = true;
                }
            });
            if (changed) this.setParked(this.parkedOrders);
        },
        heldSeqKey() {
            return this.stateKey("pos_held_id_seq");
        },
        readHeldSeq() {
            try {
                const n = Number(localStorage.getItem(this.heldSeqKey()) || 0);
                return Number.isFinite(n) ? n : 0;
            } catch (_) {
                return 0;
            }
        },
        writeHeldSeq(n) {
            localStorage.setItem(this.heldSeqKey(), String(n));
        },
        peekNextHeldId() {
            return this.readHeldSeq() + 1;
        },
        getNextHeldId() {
            const next = this.readHeldSeq() + 1;
            this.writeHeldSeq(next);
            return next;
        },
        timeAgo(ts) {
            try {
                const diff = Math.max(0, Date.now() - Number(ts || 0));
                const m = Math.floor(diff / 60000);
                if (m < 1) return "just now";
                if (m < 60) return `${m} min ago`;
                const h = Math.floor(m / 60);
                const rm = m % 60;
                return rm ? `${h}h ${rm}m ago` : `${h}h ago`;
            } catch (_) {
                return "";
            }
        },
        itemsCount(o) {
            return (o.lines || []).reduce((a, l) => a + Number(l.qty || 0), 0);
        },

        parkKey(ord) {
            return String(ord?._key || ord?.time || "");
        },
        removeParkedByKey(key) {
            const i = this.parkedOrders.findIndex(
                (o) => this.parkKey(o) === String(key)
            );
            if (i >= 0) {
                this.parkedOrders.splice(i, 1);
                this.setParked(this.parkedOrders);
            }
        },

        handleKbInput(val) {
            this.searchQueryRaw = val;
            this.debouncedSearch();
        },
        submitSearch() {
            // optional: force immediate search & close
            this.searchQuery = this.searchQueryRaw;
            this.showSearchKb = false;
        },
        // Friendly emoji if no image available
        iconForCategory(name = "") {
            const n = name.toLowerCase();
            if (n.includes("pizza")) return "🍕";
            if (n.includes("burger")) return "🍔";
            if (
                n.includes("drink") ||
                n.includes("juice") ||
                n.includes("boisson")
            )
                return "🥤";
            if (n.includes("dessert") || n.includes("sweet")) return "🍰";
            if (n.includes("salad")) return "🥗";
            if (n.includes("coffee") || n.includes("café")) return "☕";
            if (n.includes("sandwich")) return "🥪";
            return "🍽️";
        },
        authHeaders() {
            return this.authToken
                ? { Authorization: "Bearer " + this.authToken }
                : {};
        },
        slug(s) {
            return (s || "")
                .toString()
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/[^a-z0-9]+/g, "-")
                .replace(/(^-|-$)+/g, "");
        },
        isoCurrency() {
            const raw = (this.currency || "").trim().toUpperCase();
            if (raw === "DH" || raw === "MAD") return "MAD";
            if (/^[A-Z]{3}$/.test(raw)) return raw;
            return null;
        },
        money(n) {
            const v = Number(n || 0);
            try {
                if (this.numberFmt) return this.numberFmt.format(v);
            } catch (_) {}
            return v.toFixed(2) + this.currency;
        },

        keyScope() {
            return String(this.storageScope || "rest");
        },
        stateKey(name) {
            return `${name}:${this.keyScope()}`;
        },

        toast(html) {
            const host = document.getElementById("toast");
            if (!host) return;
            const el = document.createElement("div");
            el.className = "toast";
            el.innerHTML = html;
            host.appendChild(el);
            setTimeout(() => {
                el.remove();
            }, 3000);
        },

        debouncedSearch() {
            clearTimeout(this._searchT);
            this._searchT = setTimeout(() => {
                this.searchQuery = this.searchQueryRaw;
            }, 180);
        },

        async fetchMe() {
            if (!this.authToken) return null;
            try {
                const res = await fetch(this.meEndpoint, {
                    headers: {
                        Accept: "application/json",
                        ...this.authHeaders(),
                    },
                });
                if (res.status === 401) {
                    // token invalid/expired
                    this.authToken = null;
                    localStorage.removeItem("pos_token");
                    return null;
                }
                if (!res.ok) return null;
                return await res.json();
            } catch (_) {
                return null;
            }
        },

        async initAuth() {
            const me = await this.fetchMe();
            this.authedUser = me || null;
            this.authReady = true;
        },
        async login() {
            this.loginError = "";
            this.authLoading = true;
            try {
                const res = await fetch(this.loginEndpoint, {
                    method: "POST",
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({
                        staff_code: this.loginForm.code,
                        pin: this.loginForm.pin,
                    }),
                });

                if (!res.ok) {
                    let msg = "Invalid credentials.";
                    try {
                        const j = await res.json();
                        if (j?.message) msg = j.message;
                    } catch (_) {}
                    throw new Error(msg);
                }

                const j = await res.json(); // expects { token, user }
                this.authToken = j.token;
                localStorage.setItem("pos_token", j.token);

                // set user (or re-fetch with /me if you prefer)
                this.authedUser = j.user || (await this.fetchMe()) || {};
            } catch (err) {
                this.loginError = err?.message || "Login failed.";
            } finally {
                this.authLoading = false;
            }
        },

        async logout() {
            this.authLoading = true;
            try {
                if (this.authToken) {
                    await fetch(this.logoutEndpoint, {
                        method: "POST",
                        headers: {
                            Accept: "application/json",
                            ...this.authHeaders(),
                        },
                        body: JSON.stringify({}),
                    });
                }
            } catch (_) {
                /* ignore */
            }
            this.authToken = null;
            localStorage.removeItem("pos_token");
            this.authedUser = null;
            this.authLoading = false;
        },

        appendPin(d) {
            this.loginForm.pin = (this.loginForm.pin || "") + String(d);
        },
        backspacePin() {
            this.loginForm.pin = (this.loginForm.pin || "").slice(0, -1);
        },
        clearPin() {
            this.loginForm.pin = "";
        },

        // Order type & tables
        setOrderType(type) {
            this.orderType = type;
            if (type !== "dinein") this.currentTable = null;
        },
        openTables() {
            this.showTables = true;
        },
        closeTables() {
            this.showTables = false;
        },
        selectTable(i) {
            if (this.orderType !== "dinein") return;
            // allow clicking the already-selected table to just close
            this.currentTable = i;
            this.showTables = false; // ✅ auto-dismiss
        },

        clearTable() {
            this.currentTable = null;
        },

        // Categories
        setCat(slug) {
            this.activeCat = slug;
        },

        // Item modal helpers
        clearGroup(v) {
            v._selected = [];
        },

        // Items & config
        openItem(item) {
            const raw = item.raw || {};
            const singles = [];
            const normals = [];

            (item.variations || []).forEach((v, idx) => {
                const options = Array.isArray(v.options) ? v.options : [];
                const isRequiredFlag =
                    v.is_required === true ||
                    v.is_required === 1 ||
                    v.is_required === "1";
                const maxSel =
                    v.max_selections != null
                        ? parseInt(v.max_selections, 10)
                        : 1;
                const isSingle = maxSel === 1;
                const minIfRequired =
                    v.min_selections != null
                        ? parseInt(v.min_selections, 10)
                        : 1;
                const minSel = isRequiredFlag ? minIfRequired : 0;
                const available = options.filter(
                    (o) => String(o.is_available) !== "0"
                );
                const availableCount = available.length;
                const effectiveMin = Math.min(minSel, availableCount);

                if (options.length === 1 && isSingle && effectiveMin === 1) {
                    const o = options[0] || {};
                    singles.push({
                        id: o.id ?? `o${idx}`,
                        name: v.name,
                        price_adjustment: Number(o.price_adjustment || 0) || 0,
                        is_available: String(o.is_available) !== "0",
                    });
                } else {
                    normals.push({
                        ...v,
                        _single: isSingle,
                        _min: effectiveMin,
                        _max: maxSel,
                        _selected: [],
                        options: options,
                    });
                }
            });

            normals.forEach((v) => {
                const enabled = (v.options || []).filter(
                    (o) => String(o.is_available) !== "0"
                );
                const defs = enabled.filter(
                    (o) => String(o.is_default) === "1"
                );
                if (defs.length)
                    v._selected = v._single ? [defs[0]] : defs.slice();
                else if (v._min > 0 && enabled.length === 1)
                    v._selected = [enabled[0]];
            });

            if (singles.length) {
                normals.push({
                    id: "supplements",
                    name: "Supplements",
                    _single: false,
                    _min: 0,
                    _max: singles.length,
                    _selected: [],
                    options: singles.map((s) => ({
                        id: `supp-${s.id}`,
                        name: s.name,
                        price_adjustment: s.price_adjustment,
                        is_available: s.is_available ? "1" : "0",
                    })),
                });
            }

            this.cfgItem = {
                name: item.name,
                desc: item.desc || raw.description || "",
                img: item.image || this.placeholder,
                base: Number(item.base || 0),
                qty: item.minq || 1,
                minq: item.minq || 1,
                maxq: item.maxq || null,
                variations: normals,
                catalog_item_id: raw.id || null,
                catalog_category_id:
                    raw.item_category_id ||
                    (raw.category && raw.category.id) ||
                    null,
                category_name: item.categoryName || null,
                preparation_time: raw.preparation_time || null,
            };

            this.showCfgModal = true;
        },
        closeCfg() {
            this.showCfgModal = false;
        },

        vSingle(v) {
            return !!v._single;
        },
        minSel(v) {
            return Number(v._min || 0);
        },
        maxSel(v) {
            return Number(v._max || (this.vSingle(v) ? 1 : 99));
        },
        adj(o) {
            return Number(o && (o.price_adjustment || 0)) || 0;
        },
        selectedOptions(v) {
            return Array.isArray(v._selected) ? v._selected : [];
        },
        selectedCount(v) {
            return this.selectedOptions(v).length;
        },
        isOptionSelected(v, o) {
            const oid = String(o?.id ?? o);
            return this.selectedOptions(v).some(
                (x) => String(x?.id ?? x) === oid
            );
        },
        toggleOption(v, o) {
            if (String(o.is_available) === "0") return;
            const oid = String(o?.id ?? o);
            if (this.vSingle(v)) {
                const already = this.selectedOptions(v).find(
                    (x) => String(x?.id ?? x) === oid
                );
                if (already && this.minSel(v) === 0) {
                    v._selected = [];
                } else {
                    v._selected = [o];
                }
            } else {
                const idx = this.selectedOptions(v).findIndex(
                    (x) => String(x?.id ?? x) === oid
                );
                if (idx >= 0) v._selected.splice(idx, 1);
                else if (this.selectedCount(v) < this.maxSel(v))
                    v._selected.push(o);
            }
        },
        incCfgQty() {
            const max = Number(this.cfgItem.maxq || Infinity);
            this.cfgItem.qty = Math.min(max, Number(this.cfgItem.qty || 1) + 1);
        },
        decCfgQty() {
            const min = Number(this.cfgItem.minq || 1);
            this.cfgItem.qty = Math.max(
                min,
                Number(this.cfgItem.qty || min) - 1
            );
        },
        gatherSelections() {
            const selections = [];
            (this.cfgItem.variations || []).forEach((v) => {
                const opts = this.selectedOptions(v).map((o) => ({
                    name: o.name || "",
                    adj: this.adj(o),
                }));
                if (opts.length)
                    selections.push({ name: v.name, options: opts });
            });
            return selections;
        },
        addToCart() {
            if (!this.cfgValid) return;
            const qty = Number(this.cfgItem.qty || 1);
            const unit = Number(this.cfgUnitPrice || 0);
            const selections = this.gatherSelections();

            const key = JSON.stringify({ n: this.cfgItem.name, s: selections });
            let merged = false;
            for (let i = 0; i < this.cartLines.length; i++) {
                const k2 = JSON.stringify({
                    n: this.cartLines[i].name,
                    s: this.cartLines[i].selections,
                });
                if (k2 === key) {
                    this.cartLines[i].qty += qty;
                    merged = true;
                    break;
                }
            }
            if (!merged) {
                this.cartLines.push({
                    id: "id" + Math.random().toString(36).slice(2, 9),
                    name: this.cfgItem.name,
                    unit,
                    qty,
                    selections,
                    base: Number(this.cfgItem.base || 0),
                    catalog_item_id: this.cfgItem.catalog_item_id || null,
                    catalog_category_id:
                        this.cfgItem.catalog_category_id || null,
                    categoryName: this.cfgItem.category_name || null,
                    image_url: this.cfgItem.img || null,
                    preparation_time: this.cfgItem.preparation_time || null,
                    minq: this.cfgItem.minq || 1,
                    maxq: this.cfgItem.maxq || null,
                });
            }
            this.closeCfg();
        },

        // Cart ops
        incQty(idx) {
            this.cartLines[idx].qty += 1;
        },
        decQty(idx) {
            this.cartLines[idx].qty = Math.max(1, this.cartLines[idx].qty - 1);
        },
        rmLine(idx) {
            const removed = this.cartLines.splice(idx, 1)[0];
            this.toast(
                `Removed “${removed?.name}” <button class="btn btn-sm btn-sub" onclick="window._undo?.()">Undo</button>`
            );
            window._undo = () => {
                this.cartLines.splice(idx, 0, removed);
                this.toast("Restored.");
                window._undo = null;
            };
        },
        clearCart() {
            this.cartLines = [];
            this.activeParkedKey = null;
        },

        // Persistence (scoped)
        saveCartState() {
            try {
                const state = {
                    cartLines: this.cartLines,
                    discountType: this.discountType,
                    discountValue: this.discountValue,
                    orderType: this.orderType,
                    currentTable: this.currentTable,
                    payParts: this.payParts,
                };
                localStorage.setItem(
                    this.stateKey("pos_cart_state"),
                    JSON.stringify(state)
                );
            } catch (_) {}
        },
        loadCartState() {
            try {
                const s = JSON.parse(
                    localStorage.getItem(this.stateKey("pos_cart_state")) ||
                        "{}"
                );
                if (s && typeof s === "object") {
                    if (Array.isArray(s.cartLines))
                        this.cartLines = s.cartLines;
                    if (s.discountType) this.discountType = s.discountType;
                    if (typeof s.discountValue !== "undefined")
                        this.discountValue = s.discountValue;
                    if (s.orderType) this.orderType = s.orderType;
                    if (typeof s.currentTable !== "undefined")
                        this.currentTable = s.currentTable;
                    if (Array.isArray(s.payParts)) this.payParts = s.payParts;
                }
            } catch (_) {}
        },

        // Parked local (scoped)
        PARK_KEY() {
            return this.stateKey("pos_parked_orders");
        },
        getParked() {
            try {
                return JSON.parse(
                    localStorage.getItem(this.PARK_KEY()) || "[]"
                );
            } catch (e) {
                return [];
            }
        },
        setParked(a) {
            localStorage.setItem(this.PARK_KEY(), JSON.stringify(a));
        },
        holdOrder() {
            if (!this.cartLines.length || this.saving) return;

            const sub = this.subtotal;
            const disc = this.discountAmount;
            const total = sub - disc;

            // If we’re updating an existing held order, keep its id & key.
            let existingIdx = -1;
            let id,
                key = this.activeParkedKey || null;

            if (this.activeParkedKey) {
                existingIdx = this.parkedOrders.findIndex(
                    (o) => this.parkKey(o) === this.activeParkedKey
                );
                if (existingIdx >= 0) {
                    id = this.parkedOrders[existingIdx].id; // ✅ preserve number
                    key = this.parkedOrders[existingIdx]._key || key; // keep same key
                }
            }

            // For new holds, pick the smallest available number (1 if empty)
            if (id == null) id = this.nextHoldNumber();
            if (!key) {
                key =
                    "p" +
                    Date.now().toString(36) +
                    Math.random().toString(36).slice(2, 8);
            }

            const ord = {
                id,
                _key: key,
                time: Date.now(), // you can keep or update time as you prefer
                type: this.orderType,
                table: this.currentTable,
                lines: JSON.parse(JSON.stringify(this.cartLines)),
                total,
            };

            if (existingIdx >= 0) {
                this.parkedOrders.splice(existingIdx, 1, ord); // replace in place
            } else {
                this.parkedOrders.unshift(ord); // add new
            }
            this.setParked(this.parkedOrders);

            // clear current order & table after holding
            this.cartLines = [];
            this.activeParkedKey = null;
            this.clearTable();

            this.toast("Order held.");
        },

        resumeParked(i) {
            const ord = this.parkedOrders[i];
            if (!ord) return;

            this.cartLines = JSON.parse(JSON.stringify(ord.lines || []));
            this.setOrderType(ord.type || "dinein");
            this.currentTable = ord.table || null;

            this.activeParkedKey = this.parkKey(ord);
            this.toast(`Loaded held order #${ord.id || ""}`);

            // ✅ close the modal after loading
            this.showHeldModal = false;
        },
        resumeParkedByKey(key) {
            const i = this.parkedOrders.findIndex(
                (o) => this.parkKey(o) === String(key)
            );
            if (i >= 0) this.resumeParked(i);
        },
        // replace your existing deleteParked with this safe version
        deleteParked(i) {
            const ord = this.parkedOrders[i];
            if (!ord) return;
            const key = this.parkKey(ord);
            this.parkedOrders.splice(i, 1);
            this.setParked(this.parkedOrders);
            if (this.activeParkedKey === key) this.activeParkedKey = null;
        },

        // add a key-based variant and use it from the modal to avoid index mismatch
        deleteParkedByKey(key) {
            const idx = this.parkedOrders.findIndex(
                (o) => this.parkKey(o) === String(key)
            );
            if (idx === -1) return;
            if (this.activeParkedKey === String(key))
                this.activeParkedKey = null;
            this.parkedOrders.splice(idx, 1);
            this.setParked(this.parkedOrders);
        },

        // Daily order sequence
        todayStr() {
            const d = new Date();
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, "0");
            const day = String(d.getDate()).padStart(2, "0");
            return `${y}-${m}-${day}`;
        },
        readDailySeq() {
            try {
                const raw = JSON.parse(
                    localStorage.getItem(
                        this.stateKey("pos_daily_order_seq")
                    ) || "{}"
                );
                if (!raw || typeof raw !== "object")
                    return { day: this.todayStr(), last: 0 };
                return raw;
            } catch (_) {
                return { day: this.todayStr(), last: 0 };
            }
        },
        writeDailySeq(obj) {
            localStorage.setItem(
                this.stateKey("pos_daily_order_seq"),
                JSON.stringify(obj)
            );
        },
        peekNextDailyOrder() {
            const today = this.todayStr();
            const s = this.readDailySeq();
            return s.day === today ? s.last + 1 : 1;
        },
        getNextDailyOrder() {
            const today = this.todayStr();
            const s = this.readDailySeq();
            const seq = s.day === today ? Number(s.last || 0) + 1 : 1;
            this.writeDailySeq({ day: today, last: seq });
            return seq;
        },

        // Payment
        quickCash(val) {
            this.payGiven = Number(val || 0);
        },
        addPayPart() {
            const remaining = Math.max(0, this.grandTotal - this.payPartsTotal);
            this.payParts.push({
                method: this.payMethod,
                amount: remaining || 0,
            });
        },
        openPay() {
            this.payGiven = 0;
            this.payMethod = "cash";
            this.nextDailyOrderPreview = this.peekNextDailyOrder();
            this.showPayModal = true;
        },
        closePay() {
            this.showPayModal = false;
        },

        // Build payload
        buildOrderPayload(withPayment = true, extras = {}) {
            const currency = (this.currency || "").replace(/\s+/g, "");
            const lines = this.cartLines.map((l) => {
                const sumAdj = (l.selections || []).reduce((acc, sel) => {
                    return (
                        acc +
                        (sel.options || []).reduce(
                            (a, o) => a + Number(o.adj || 0),
                            0
                        )
                    );
                }, 0);
                const base =
                    typeof l.base === "number"
                        ? l.base
                        : Math.max(0, Number(l.unit || 0) - sumAdj);
                return {
                    catalog_item_id: l.catalog_item_id || null,
                    catalog_category_id: l.catalog_category_id || null,
                    item_name: l.name,
                    category_name: l.categoryName || null,
                    image_url: l.image_url || null,
                    base_unit_price: base,
                    unit_price: Number(l.unit || 0),
                    quantity: Number(l.qty || 1),
                    preparation_time: l.preparation_time || null,
                    min_qty: l.minq || 1,
                    max_qty: l.maxq || null,
                    selections: (l.selections || []).map((v) => ({
                        variation_name: v.name,
                        options: (v.options || []).map((o) => ({
                            option_name: o.name,
                            price_adjustment: Number(o.adj || 0),
                        })),
                    })),
                };
            });

            const payload = {
                restaurant_id: this.restaurant?.id || null,
                order_type: this.orderType,
                table_number: this.currentTable || null,
                currency,
                discount: {
                    type: this.discountType,
                    value: Number(this.discountValue || 0),
                },
                hold: false,
                lines,
                notes: null,
                ...extras,
            };

            if (withPayment) {
                if (this.payParts.length) {
                    payload.payments = this.payParts.map((p) => ({
                        method: p.method,
                        amount: Number(p.amount || 0),
                        amount_given: Number(p.amount || 0),
                        change_due: 0,
                        paid_at: new Date().toISOString(),
                    }));
                } else {
                    payload.payment = {
                        method: this.payMethod,
                        amount: Number(this.grandTotal),
                        amount_given: Number(this.payGiven || 0),
                        paid_at: new Date().toISOString(),
                    };
                }
            }

            return payload;
        },

        async postOrder(payload) {
            const res = await fetch(this.ordersEndpoint, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    ...this.authHeaders(),
                },
                body: JSON.stringify(payload),
            });

            if (res.status === 401) {
                // token expired → force re-auth
                this.authToken = null;
                localStorage.removeItem("pos_token");
                this.authedUser = null;
            }

            if (!res.ok) {
                let msg = `Failed to save order (${res.status})`;
                try {
                    const j = await res.json();
                    if (j && j.message) msg = j.message;
                } catch (_) {}
                throw new Error(msg);
            }
            return res.json();
        },

        printReceiptFromOrder(order) {
            const w = window.open("", "PRINT", "height=600,width=380");
            w.document.write(`<html><head><title>Receipt</title><style>
                body{font-family:monospace;padding:8px}
                h2,h3{margin:4px 0}
                .line{display:flex;justify-content:space-between}
                .small{font-size:12px;color: #000}
                hr{border:none;border-top:1px dashed #999;margin:6px 0}
            </style></head><body>`);

            const orderCode = order.order_code || order.id || "";
            const createdAt = order.created_at
                ? new Date(order.created_at)
                : new Date();
            const daily = order.daily_order || order.daily || null;
            const logoSrc = this.restaurant?.logo || null;
            w.document.write(
                //logo
                '<div style="text-align:center;margin-bottom:2px">' +
                    (logoSrc
                        ? `<img src="${logoSrc}" alt="Logo" style="max-width:120px;max-height:80px"/>`
                        : "") +
                    "</div>"
            );
            w.document.write(
                `<h2 style="text-align:center">${
                    this.restaurantName
                }</h2><div class="small">${
                    this.restaurantAddress || ""
                }</div><hr>`
            );
            if (daily) {
                w.document.write(`<h3>Ticket #${daily}</h3>`);
                w.document.write(
                    `<div class="small">Order ref: ${orderCode}</div>`
                );
            } else {
                w.document.write(`<div>Order ref: ${orderCode}</div>`);
            }
            w.document.write(
                `<div class="small">${createdAt.toLocaleString()}</div><div class="small">Type: ${String(
                    order.order_type || ""
                ).toUpperCase()}${
                    order.table_number ? " • Table " + order.table_number : ""
                }</div><hr>`
            );

            (order.items || []).forEach((l) => {
                w.document.write(
                    `<div><strong>${l.item_name}</strong> x${l.quantity}</div>`
                );
                (l.options || []).forEach((op) => {
                    const adj = Number(op.price_adjustment || 0);
                    const plus = adj
                        ? ` (+${adj.toFixed(2)}${this.currency})`
                        : ``;
                    w.document.write(
                        `<div class="small"> - ${op.variation_name}: ${op.option_name}${plus}</div>`
                    );
                });
                w.document.write(
                    `<div class="line"><span class="small">Unit:</span><span>${Number(
                        l.unit_price || 0
                    ).toFixed(2)}${this.currency}</span></div>`
                );
                w.document.write(
                    `<div class="line"><span class="small">Line:</span><span>${Number(
                        l.line_total || 0
                    ).toFixed(2)}${this.currency}</span></div><hr>`
                );
            });

            w.document.write(
                `<div class="line"><strong>Subtotal</strong><strong>${Number(
                    order.subtotal || 0
                ).toFixed(2)}${this.currency}</strong></div>`
            );
            if (Number(order.discount_amount || 0) > 0) {
                w.document.write(
                    `<div class="line"><span class="small">Discount</span><span class="small">-${Number(
                        order.discount_amount
                    ).toFixed(2)}${this.currency}</span></div>`
                );
            }
            w.document.write(
                `<div class="line"><strong>Grand Total</strong><strong>${Number(
                    order.total || 0
                ).toFixed(2)}${this.currency}</strong></div><hr>`
            );

            const lastPay =
                order.payments && order.payments[0] ? order.payments[0] : null;
            if (lastPay) {
                w.document.write(
                    `<div class="small">Paid by: ${String(
                        lastPay.method || ""
                    ).toUpperCase()} • Given: ${Number(
                        lastPay.amount_given || 0
                    ).toFixed(2)}${this.currency} • Change: ${Number(
                        lastPay.change_due || 0
                    ).toFixed(2)}${this.currency}</div>`
                );
            }

            w.document.write(
                `<p class="small" style="text-align:center;margin-top:10px">*** Thank you! ***</p>`
            );
            w.document.write(`</body></html>`);
            w.document.close();
            w.focus();
            w.print();
            w.close();
        },

        async finalize(printIt) {
            if (!this.cartLines.length || this.saving || !this.isAuthed) return;
            this.saving = true;
            let daily = null;
            try {
                daily = this.getNextDailyOrder();
                const payload = this.buildOrderPayload(true, {
                    daily_order: daily,
                });
                const saved = await this.postOrder(payload);

                try {
                    const key = this.stateKey("pos_completed_orders");
                    const arr = JSON.parse(localStorage.getItem(key) || "[]");
                    arr.unshift(saved);
                    localStorage.setItem(key, JSON.stringify(arr));
                } catch (e) {}

                this.closePay();

                if (printIt) {
                    const withDaily = {
                        ...saved,
                        daily_order: saved.daily_order ?? daily,
                    };
                    this.printReceiptFromOrder(withDaily);
                }
                if (this.activeParkedKey) {
                    this.removeParkedByKey(this.activeParkedKey); // consume the hold
                    this.activeParkedKey = null;
                }

                this.cartLines = [];
                this.discountType = "amount";
                this.discountValue = 0;
                this.payParts = [];
                this.nextDailyOrderPreview = null;
                this.clearTable();
            } catch (err) {
                const key = this.stateKey("pos_pending_orders");
                const arr = JSON.parse(localStorage.getItem(key) || "[]");
                arr.unshift({
                    payload: this.buildOrderPayload(true, {
                        daily_order: daily ?? this.peekNextDailyOrder(),
                    }),
                    reason: err.message,
                    time: Date.now(),
                });
                localStorage.setItem(key, JSON.stringify(arr));
                this.loadPendingOrders();
                alert("No connection? Order saved to pending.");
            } finally {
                this.saving = false;
            }
        },

        loadPendingOrders() {
            try {
                this.pendingOrders = JSON.parse(
                    localStorage.getItem(this.stateKey("pos_pending_orders")) ||
                        "[]"
                );
            } catch (_) {
                this.pendingOrders = [];
            }
        },
        async retryPending() {
            if (!this.pendingOrders.length) return;
            const next = this.pendingOrders[0];
            try {
                const saved = await this.postOrder(next.payload);
                this.pendingOrders.shift();
                localStorage.setItem(
                    this.stateKey("pos_pending_orders"),
                    JSON.stringify(this.pendingOrders)
                );
                this.toast("Pending order synced.");
                this.printReceiptFromOrder(saved);
            } catch (e) {
                alert("Retry failed: " + (e?.message || "Error"));
            } finally {
                this.loadPendingOrders();
            }
        },

        // Scanner
        openScan() {
            this.showScanModal = true;
            this.$nextTick(() => {
                if (window.Html5QrcodeScanner) {
                    this.qrAvailable = true;
                    this.qrScanner = new window.Html5QrcodeScanner("qrReader", {
                        fps: 10,
                        qrbox: 250,
                    });
                    this.qrScanner.render(
                        (decodedText) => {
                            const payload = this.tryParsePayload(decodedText);
                            if (this.importClientOrder(payload)) {
                                this.closeScan();
                            }
                        },
                        () => {}
                    );
                } else {
                    this.qrAvailable = false;
                }
            });
        },
        closeScan() {
            try {
                this.qrScanner &&
                    this.qrScanner.clear &&
                    this.qrScanner.clear();
            } catch (e) {}
            this.qrScanner = null;
            this.showScanModal = false;
        },
        tryParsePayload(raw) {
            if (!raw) return null;
            try {
                if (/^https?:\/\//i.test(raw)) {
                    const u = new URL(raw);
                    const p = u.searchParams.get("data");
                    if (p) raw = p;
                }
            } catch (e) {}
            try {
                return JSON.parse(raw);
            } catch (e) {}
            try {
                const txt = atob(raw);
                return JSON.parse(txt);
            } catch (e) {}
            return null;
        },
        importClientOrder(payload) {
            if (!payload || !Array.isArray(payload.items)) {
                alert("Invalid client code");
                return false;
            }
            payload.items.forEach((it) => {
                const name = it.name;
                const qty = parseInt(it.qty || 1, 10);
                const unit = parseFloat(
                    it.unit || this.menuIndex()[name]?.base || 0
                );
                const selections = (it.sel || []).map((v) => ({
                    name: v.name,
                    options: (v.options || []).map((o) => ({
                        name: o.n || o.name || "",
                        adj: parseFloat(o.a ?? o.adj ?? 0) || 0,
                    })),
                }));
                const key = JSON.stringify({ n: name, s: selections });
                let merged = false;
                for (let i = 0; i < this.cartLines.length; i++) {
                    const k2 = JSON.stringify({
                        n: this.cartLines[i].name,
                        s: this.cartLines[i].selections,
                    });
                    if (k2 === key) {
                        this.cartLines[i].qty += qty;
                        merged = true;
                        break;
                    }
                }
                if (!merged)
                    this.cartLines.push({
                        id: "id" + Math.random().toString(36).slice(2, 9),
                        name,
                        unit,
                        qty,
                        selections,
                    });
            });
            return true;
        },
        categoryThumb(cat) {
            // Accepts a category object or null for "All"
            const ph = this.placeholder; // already in props
            if (!cat) {
                // "All" – use first seen item image if any
                return this.catMeta["__all"]?.img || ph;
            }
            return cat.image || this.catMeta[cat.slug]?.img || ph;
        },
        menuIndex() {
            const idx = {};
            this.normalizedItems.forEach((it) => {
                idx[it.name] = {
                    base: it.base,
                    img: it.image,
                    desc: it.desc,
                    variations: it.variations,
                    minq: it.minq,
                    maxq: it.maxq,
                };
            });
            return idx;
        },
    },
};
</script>

<style>
:root {
    /* ===== Fresh café/restaurant green palette ===== */
    --brand: #0f8b4c; /* primary green */
    --brand-600: #0b6b3e; /* darker */
    --brand2: #cfeedd; /* soft green border fill */
    --brand2-strong: #a9e0c2; /* stronger soft */
    --ink: #1f2937;
    --muted: #6b7280;
    --soft: #f4fbf6; /* background */
    --card: #ffffff;
    --line: #dcefe2; /* soft green divider */
    --ring: rgba(15, 139, 76, 0.22);
    --success: #16a34a;
    --danger: #ef4444;
    --warning: #f59e0b;
    --accent: #22c55e;
    --mint: #e9f8ef;
    --pearl: #f7fdf9;
    --cat-active-border: #7fd5b8; /* visible mint border on select (light) */
    --cat-avatar-bg: #eaf7f0; /* visible soft mint */
}
:root[data-theme="dark"] {
    --soft: #0b1220;
    --card: #0f172a;
    --ink: #e5e7eb;
    --muted: #94a3b8;
    --line: #1f2a44;
    --brand: #22c55e;
    --brand-600: #16a34a;
    --brand2: #0c1a13;
    --mint: #0f1f17;
    --pearl: #0b1510;
    --cat-active-border: #34d399; /* brighter in dark */
}

* {
    box-sizing: border-box;
}
html {
    scroll-behavior: smooth;
}
body {
    font-family: "Inter", system-ui, -apple-system, Segoe UI, Roboto, Helvetica,
        Arial, sans-serif;
    color: var(--ink);
    background: var(--soft);
    overflow-x: hidden; /* prevent accidental horizontal scroll pushing cart out of view */
}

/* ===== Header ===== */
.pos-header {
    position: sticky;
    top: 0;
    z-index: 70;
    background: linear-gradient(135deg, var(--pearl) 0%, var(--mint) 100%);
    border-bottom: 1px solid #e6f3ea;
    padding: 0.6rem 0;
}
.brand-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.logo-ring {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #eef8f1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
}
.logo-ring img {
    width: 86%;
    height: 86%;
    object-fit: contain;
    border-radius: 50%;
}
.brand-title {
    display: flex;
    flex-direction: column;
}
.brand-title h1 {
    font-family: "Playfair Display", serif;
    font-size: 1.25rem;
    font-weight: 800;
    line-height: 1;
    margin: 0;
}
.brand-title small {
    color: #4b5563;
}
.header-tools {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    justify-content: flex-end;
}

/* Language switcher */
.btn-pill {
    background: #fff;
    border: 1px solid #dbeee3;
    color: var(--ink);
    padding: 0.35rem 0.7rem;
    border-radius: 999px;
    font-weight: 700;
    font-size: 0.9rem;
    transition: 0.2s;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}
.btn-pill:hover {
    background: #f5fbf7;
}
.dropdown-menu {
    border: none;
    border-radius: 0.75rem;
    padding: 0.35rem;
    min-width: 12rem;
    background: #fff;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.12);
}
.dropdown-item {
    border-radius: 0.5rem;
    padding: 0.5rem 0.75rem;
    color: #111;
}
.dropdown-item:hover {
    background: rgba(15, 139, 76, 0.08);
}
.dropdown-item.active {
    background: linear-gradient(135deg, #e8f7ee, #fff);
    font-weight: 800;
}

/* Header table toggle */
.btn-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid #dbeee3;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.table-badge {
    background: #111827;
    color: #fff;
    border-radius: 6px;
    padding: 0.1rem 0.4rem;
    font-size: 0.7rem;
    font-weight: 800;
}
.pending-dot {
    position: absolute;
    top: -6px;
    inset-inline-end: -6px;
    background: #dc2626;
    color: #fff;
    font-size: 0.7rem;
    padding: 0.05rem 0.35rem;
    border-radius: 999px;
    border: 2px solid #fff;
}

/* ===== Shell layout ===== */
.pos-shell {
    display: grid;
    gap: 1rem;
    /* was: minmax(0, 1fr) clamp(320px, 30vw, 390px) */
    grid-template-columns: minmax(0, 1fr) clamp(360px, 34vw, 440px);
    padding: 0.9rem 0.9rem 1.2rem;
}
@media (max-width: 1200px) {
    .pos-shell {
        /* was: clamp(300px, 34vw, 360px) */
        grid-template-columns: minmax(0, 1fr) clamp(340px, 38vw, 400px);
    }
}
@media (max-width: 1100px) {
    .pos-shell {
        grid-template-columns: 1fr;
    }
}

/* ===== Panels ===== */
.panel {
    background: var(--card);
    border: 1px solid var(--line);
    border-radius: 1rem;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
    min-width: 0; /* IMPORTANT: allow grid children to shrink to avoid overflow */
}
.panel-head {
    padding: 0.6rem 0.9rem;
    border-bottom: 1px solid var(--line);
}
.panel-body {
    padding: 0.8rem;
}

/* ===== Order type CARDS ===== */
.choice-cards {
    display: grid;
    gap: 0.5rem;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    margin-bottom: 0.6rem;
}
@media (max-width: 576px) {
    .choice-cards {
        grid-template-columns: 1fr 1fr 1fr;
    }
}
.choice-card {
    border: 2px solid #e4f4ea;
    background: #fff;
    border-radius: 0.9rem;
    padding: 0.6rem 0.7rem;
    display: flex;
    gap: 0.6rem;
    align-items: center;
    cursor: pointer;
    user-select: none;
    transition: 0.15s;
}
.choice-card:hover,
.choice-card:focus {
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    transform: translateY(-1px);
    outline: 3px solid var(--ring);
    outline-offset: 2px;
}
.choice-card.active {
    box-shadow: 0 0 0 4px var(--ring);
    border-color: var(--brand2);
}
.choice-ico {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: #f2fbf5;
    border: 1px solid #d8efe0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--brand-600);
    font-size: 1rem;
    flex-shrink: 0;
}
.choice-label {
    font-weight: 800;
}

/* ===== Search & actions row ===== */
.search-row {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-wrap: wrap;
    justify-content: space-between;
}
.pos-search {
    border: 2px solid #e4f4ea;
    border-radius: 999px;
    padding: 0.55rem 0.9rem;
    min-width: 280px;
    flex: 1;
}
.pos-search:focus {
    border-color: var(--brand2);
    box-shadow: 0 0 0 6px var(--ring);
    outline: 0;
}
.import-wrap {
    display: flex;
    gap: 0.35rem;
    align-items: center;
}

.btn-sub {
    border: 1px solid #e4f4ea;
    background: #fff;
    border-radius: 0.7rem;
    font-weight: 700;
}

/* ===== Categories ===== */
.categories-scroll {
    position: sticky;
    top: 68px;
    background: var(--card);
    z-index: 30;
    display: flex;
    gap: 0.5rem;
    flex-wrap: nowrap;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
    padding: 0.9rem 0.2rem; /* extra Y padding as requested */
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.categories-scroll::-webkit-scrollbar {
    display: none;
}

.categories-scroll::before,
.categories-scroll::after {
    content: "";
    position: sticky;
    top: 0;
    width: 24px;
    height: 100%;
    pointer-events: none;
}
.categories-scroll::before {
    left: 0;
    background: linear-gradient(to right, var(--card), rgba(255, 255, 255, 0));
}
.categories-scroll::after {
    margin-left: auto;
    right: 0;
    background: linear-gradient(to left, var(--card), rgba(255, 255, 255, 0));
}

/* ===== Items grid ===== */
.items-grid {
    display: grid;
    gap: 0.7rem;
    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
    margin-top: 0.6rem;
}
.item-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.9rem;
    overflow: hidden;
    cursor: pointer;
    transition: 0.18s;
    display: flex;
    flex-direction: column;
}
.item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0, 0, 0, 0.08);
}
.item-thumb {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
.item-meta {
    padding: 0.6rem 0.65rem 0.7rem;
}
.item-meta h5 {
    font-size: 0.98rem;
    font-weight: 800;
    margin: 0 0 0.25rem;
}
.price-tag {
    font-weight: 800;
    color: var(--brand);
}

/* skeleton */
.skeleton {
    position: relative;
    height: 180px;
    background: #f1f5f9;
    overflow: hidden;
    border-radius: 0.9rem;
}
.skeleton::after {
    content: "";
    position: absolute;
    inset: 0;
    transform: translateX(-100%);
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.6),
        transparent
    );
    animation: shimmer 1.2s infinite;
}
@keyframes shimmer {
    100% {
        transform: translateX(100%);
    }
}

/* ===== Cart ===== */
.cart {
    position: sticky;
    top: 78px;
    max-height: calc(100vh - 96px);
    overflow: auto;
}
@supports (height: 100dvh) {
    .cart {
        max-height: calc(100dvh - 96px);
    } /* mobile & zoom-safe viewport units */
}
.cart-head {
    padding: 0.75rem 0.9rem;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cart-body {
    padding: 0.85rem 1rem;
}
.cart-line {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 0.4rem;
    border-bottom: 1px dashed #e4f4ea;
    padding: 0.7rem 0;
}
.cart-line:last-child {
    border-bottom: none;
}
.cart-line h6 {
    margin: 0;
    font-weight: 800;
}
.opts small {
    color: var(--muted);
}
.qty-ctrl {
    display: flex;
    align-items: center;
    gap: 0.35rem;
}
.qty-ctrl button {
    width: 26px;
    height: 26px;
    border: 1px solid #e4f4ea;
    background: #f2fbf5;
    border-radius: 6px;
}
.line-total {
    font-weight: 800;
}
.cart-foot {
    padding: 1rem 1rem;
    border-top: 1px solid var(--line);
    background: #f7fcf9;
}
.tot-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0.45rem 0;
}
.grand {
    font-size: 1.15rem;
    font-weight: 800;
}
.btn-main {
    background: var(--brand);
    color: #fff;
    border: none;
    border-radius: 0.7rem;
    font-weight: 800;
    padding: 0.6rem 0.9rem;
    box-shadow: 0 10px 22px rgba(15, 139, 76, 0.22);
}
.btn-main:hover {
    background: var(--brand-600);
}
.btn-danger-soft {
    border: 1px solid #fde2e2;
    background: #fff5f5;
    color: #991b1b;
}
.parked {
    border-top: 1px dashed #e4f4ea;
    margin-top: 0.6rem;
    padding-top: 0.6rem;
}
.order-chip {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    border: 1px dashed #e4f4ea;
    border-radius: 0.65rem;
    padding: 0.35rem 0.5rem;
    background: #fff;
    margin-bottom: 0.45rem;
}
.badge-pill {
    border-radius: 999px;
    padding: 0.15rem 0.55rem;
}

/* ===== Item Modal (regular size, extra comfy paddings) ===== */
.cfg-modal {
    max-width: 980px;
    width: min(96vw, 980px);
}
.cfg-modal .modal-content {
    border-radius: 0.8rem;
}
.cfg-modal .modal-header {
    padding: 0.7rem 0.9rem;
    background: #eefaf3;
    border-bottom: 1px solid var(--line);
}
.cfg-modal .modal-body {
    padding: 1rem;
    max-height: 75vh;
    overflow: auto;
}

/* compact grid inside modal-body */
.cfg-grid {
    display: grid;
    grid-template-columns: clamp(220px, 30%, 320px) 1fr; /* image left | content right */
    gap: 0.9rem;
}
@media (max-width: 992px) {
    .cfg-grid {
        grid-template-columns: 1fr;
    }
}

.media-wrap {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.7rem;
    padding: 0.6rem;
    display: grid;
    place-items: center;
}
#cfgImg {
    width: 100%;
    height: auto;
    max-height: 60vh;
    object-fit: cover;
    border-radius: 0.6rem;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
}

.cfg-right {
    display: grid;
    grid-template-rows: auto auto;
    gap: 0.75rem;
}
.info-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.7rem;
    padding: 0.9rem;
}
.cfg-price {
    font-weight: 800;
    color: var(--brand);
    margin: 0;
}

.opts-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.7rem;
    padding: 0.9rem;
    display: grid;
    gap: 0.75rem;
}

/* Groups & options */
.group-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.6rem;
    padding: 0.7rem 0.7rem 0.8rem;
    overflow: hidden;
}
.v-group {
    margin: 0;
}
.v-title {
    font-weight: 800;
}
.v-title-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    margin-bottom: 0.55rem;
}
.btn-clear-group {
    border: 1px dashed #d8efe0;
    background: #fff;
    color: #6b7280;
    border-radius: 999px;
    padding: 0.18rem 0.6rem;
    font-size: 0.78rem;
}
.btn-clear-group:hover {
    background: #f8fafb;
}

/* exactly 2 choices per row */
.options-grid.two-cols {
    display: grid;
    gap: 0.6rem;
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.option-card {
    position: relative;
    display: block;
    user-select: none;
    cursor: pointer;
    background: #fff;
    border: 1.5px solid #d8efe0;
    border-radius: 0.65rem;
    padding: 0.6rem 0.65rem;
    transition: 0.15s;
    height: 100%;
    max-width: 100%;
}
.option-card:hover {
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
}
.option-card.disabled {
    opacity: 0.45;
    cursor: not-allowed;
}
.option-input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 0;
    height: 0;
}

.option-inner {
    display: grid;
    grid-template-columns: auto 1fr auto;
    align-items: center;
    gap: 0.5rem;
}
.sel-check {
    opacity: 0;
    transition: 0.15s ease;
}
.option-card.selected .sel-check {
    opacity: 1;
}

.option-name {
    font-weight: 700;
    color: #1f2937;
    min-width: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.option-badge {
    background: #f2fbf5;
    border: 1px solid #d8efe0;
    color: #0d5d37;
    border-radius: 0.65rem;
    padding: 0.12rem 0.48rem;
    font-size: 0.78rem;
    white-space: nowrap;
}
.option-badge.is-zero {
    background: transparent;
    border: 1px dashed #d8efe0;
    color: #6b7280;
}

.option-card.selected {
    background: linear-gradient(0deg, #ffffff 0%, #f0fbf6 100%);
    border-color: #bfe7d2;
    box-shadow: 0 8px 18px rgba(15, 139, 76, 0.12);
}
.option-hint {
    font-size: 0.82rem;
    color: #6b7280;
    margin-top: 0.1rem;
}

/* qty */
.qty-wrap {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.qty-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 1px solid #d8efe0;
    background: #f2fbf5;
}
.qty-input {
    width: 58px;
    text-align: center;
    border: 1px solid #d8efe0;
    background: #fff;
    border-radius: 8px;
    padding: 0.28rem 0;
}
.req-hint {
    font-size: 0.88rem;
    color: #b45309;
    display: none;
}

/* ===== Payment & Scanner ===== */
.pay-methods .btn {
    border: 1px solid #e4f4ea;
    background: #fff;
    padding: 0.5rem 0.75rem;
    border-radius: 0.7rem;
    font-weight: 700;
}
.pay-methods .btn.active {
    background: #eaf6ef;
    border-color: #cde8d5;
    color: #065f46;
}
.change-box {
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
    color: #064e3b;
    border-radius: 0.6rem;
    padding: 0.45rem 0.65rem;
    font-weight: 800;
}
.daily-chip {
    background: #fff;
    border: 1px dashed #d8efe0;
    border-radius: 999px;
    padding: 0.15rem 0.6rem;
    font-size: 0.85rem;
}

/* ===== Offcanvas: Tables ===== */
.table-grid {
    display: grid;
    gap: 0.6rem;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
}
.table-card {
    border: 2px solid #e4f4ea;
    background: #fff;
    border-radius: 0.9rem;
    padding: 0.7rem 0.6rem;
    text-align: center;
    cursor: pointer;
    user-select: none;
    transition: 0.15s;
}
.table-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
}
.table-card.active {
    box-shadow: 0 0 0 4px var(--ring);
    border-color: var(--brand2);
}
.table-ico {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f2fbf5;
    border: 1px solid #d8efe0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #0b6b3e;
    margin: 0 auto 0.35rem;
}
.offcanvas-header {
    border-bottom: 1px solid var(--line);
}
.offcanvas-footer {
    border-top: 1px solid var(--line);
    padding: 0.75rem 0.9rem;
}

/* Print minimalism */
@media print {
    .pos-header,
    .panel-head,
    .categories-scroll,
    .cart-foot .btn,
    .parked {
        display: none !important;
    }
    .pos-shell {
        grid-template-columns: 1fr !important;
        padding: 0;
    }
    .panel,
    .cart {
        border: none;
        box-shadow: none;
    }
}

/* Backdrops for custom modals/offcanvas when using v-if */
.modal-backdrop.show {
    opacity: 0.5;
}
.modal.fade.show {
    display: block;
}
.offcanvas-backdrop.show {
    opacity: 0.5;
}
.offcanvas.show {
    visibility: visible;
}

/* Fullscreen login overlay */
.auth-overlay {
    position: fixed;
    inset: 0;
    background: rgba(17, 24, 39, 0.45);
    backdrop-filter: blur(2px);
    z-index: 9999;
    display: grid;
    place-items: center;
    padding: 1rem;
}
.auth-card {
    width: 100%;
    max-width: 380px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 1rem;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    padding: 1rem;
}

/* PIN keypad */
.pin-grid {
    margin-top: 0.25rem;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 0.4rem;
}
.pin-key {
    border: 1px solid #e4f4ea;
    background: #f7fcf9;
    border-radius: 0.6rem;
    padding: 0.6rem 0;
    font-weight: 800;
}
.pin-key:active {
    transform: scale(0.98);
}

/* Toasts */
.toast-pos {
    position: fixed;
    bottom: 16px;
    inset-inline-end: 16px;
    z-index: 9999;
}
.toast-pos .toast {
    background: #111827;
    color: #fff;
    padding: 0.5rem 0.75rem;
    border-radius: 0.6rem;
    margin-top: 0.4rem;
}
/* === Category image cards inside .categories-scroll === */
.categories-scroll {
    gap: 0.55rem;
    padding: 0.75rem 0.2rem;
}

.cat-thumb {
    position: relative;
    width: 150px;
    height: 86px;
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid var(--line);
    background: #fff;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
}
@media (max-width: 576px) {
    .cat-thumb {
        width: 132px;
        height: 78px;
    }
}

.cat-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    display: block;
    filter: saturate(1.05);
}

.cat-overlay {
    position: absolute;
    inset: auto 0 0 0;
    padding: 0.4rem 0.55rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.4rem;
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0) 0%,
        rgba(0, 0, 0, 0.55) 100%
    );
    color: #fff;
}
.cat-name {
    font-weight: 800;
    font-size: 0.9rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.35);
    max-width: 100px;
}
.cat-count {
    font-size: 0.75rem;
    font-weight: 800;
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 0.05rem 0.45rem;
    border-radius: 999px;
}

/* --- Category cards (white button w/ left symbol, right text) --- */
.cats-list {
    gap: 0.6rem;
    padding-block: 0.7rem; /* more comfy touch target */
}

/* card */
.cats-list .cat-btn {
    --ring: var(--ring);
    --line: var(--line);
    --bg: #fff;

    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    padding: 0.65rem 0.95rem;
    border: 2px solid transparent; /* ⬅️ was 1.5px solid var(--line) */
    background: var(--bg);
    border-radius: 1rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
    transition: transform 0.12s ease, box-shadow 0.12s ease,
        border-color 0.12s ease, background 0.12s ease;
    white-space: nowrap;
    flex: 0 0 auto;
    text-shadow: none;
}

.cats-list .cat-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    border-color: #d3efe2; /* subtle hint on hover */
}

.cats-list .cat-btn.active {
    background: var(--cat-active-bg, #f3faf6);
    border-color: var(--cat-active-border); /* ✅ now clearly visible */
    box-shadow: 0 0 0 2.5px var(--ring), 0 8px 20px rgba(15, 139, 76, 0.12);
}

.cats-list .cat-btn:focus-visible {
    outline: 3px solid var(--ring);
    outline-offset: 2px;
}

/* left thumbnail */
.cats-list .cat-avatar {
    width: 44px; /* tiny bump for presence */
    height: 44px;
    padding: 3px; /* ← shows the bg as a frame */

    border-radius: 0.8rem; /* rounded image */
    overflow: hidden;
    border: 1px solid var(--line);
    background: var(--cat-avatar-bg);
    display: grid;
    place-items: center;
    flex-shrink: 0;
}

.cats-list .cat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.cats-list .cat-fallback {
    font-size: 1.15rem;
    line-height: 1;
}

/* right text */
.cats-list .cat-text {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
    min-width: 0; /* allow truncation */
}

.cats-list .cat-name {
    font-weight: 800;
    color: var(--ink);
    max-width: 14ch;
    overflow: hidden;
    text-overflow: ellipsis;
    text-shadow: none; /* ⬅️ make sure: no text shadow */
}

.cats-list .cat-count {
    color: var(--muted);
    border: 1px solid var(--line);
    padding: 0.06rem 0.45rem;
    border-radius: 999px;
    font-weight: 700;
    background: #fff;
    text-shadow: none; /* ⬅️ no text shadow */
}

/* theme tuning */
:root {
    --cat-active-bg: #f3faf6; /* ⬅️ light, friendly active bg (light mode) */
}

:root[data-theme="dark"] .cats-list .cat-btn {
    --bg: var(--card);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
}

:root[data-theme="dark"] .cats-list .cat-avatar {
    background: #0f172a;
    border-color: #1f2a44;
}

/* Dark active state gets a soft tint instead of pure white */
:root[data-theme="dark"] {
    --cat-active-bg: rgba(
        34,
        197,
        94,
        0.1
    ); /* ⬅️ subtle brand-tinted bg in dark */
}

/* Remove focus ring/glow on the search input */
.pos-search {
    -webkit-appearance: none;
    appearance: none;
}

.pos-search:focus,
.pos-search:active,
.pos-search:focus-visible {
    box-shadow: none !important;
    outline: none !important;
    border-color: #e4f4ea !important; /* same as idle state */
}

.order-chip.is-loaded {
    border-style: solid;
    border-color: #cde8d5;
    background: #f7fcf9;
}

.held-card {
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 0.8rem;
    padding: 0.7rem;
    display: grid;
    gap: 0.4rem;
}
.held-header .held-id {
    font-weight: 800;
}
.held-type {
    font-weight: 700;
}
.held-actions {
    display: flex;
    gap: 0.4rem;
    justify-content: flex-end;
}
.table-card.disabled {
    opacity: 0.55;
    cursor: not-allowed;
}
.table-card.disabled .table-ico {
    background: #f8fafb;
    color: #9ca3af;
}
/* Held modal bigger limits */
.held-modal .modal-dialog {
    max-width: 1100px; /* ~wider than default xl */
    width: min(96vw, 1100px);
}

/* Clickable held cards */
.held-card {
    cursor: pointer;
}
.held-card:focus-visible {
    outline: 3px solid var(--ring);
    outline-offset: 2px;
}
/* Keep delete from looking disabled when card is disabled */
.held-actions .btn {
    cursor: pointer;
}
/* --- Held Modal: larger, polished container --- */
.held-modal .modal-dialog {
    max-width: 1100px;
    width: min(96vw, 1100px);
}
.held-modal-content {
    border-radius: 1rem;
    overflow: hidden;
    border: 1px solid var(--line);
    background: radial-gradient(
            1200px 200px at 100% -20%,
            rgba(34, 197, 94, 0.04),
            transparent 60%
        ),
        var(--card);
}
.held-modal-header {
    background: linear-gradient(135deg, #eefaf3 0%, #ffffff 100%);
    border-bottom: 1px solid var(--line);
}

/* --- Toolbar --- */
.held-toolbar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 0.6rem;
}
.held-search {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1.5px solid #dbeee3;
    background: #fff;
    border-radius: 0.8rem;
    padding: 0.4rem 0.6rem;
    min-width: 260px;
    flex: 1 1 320px;
}
.held-search i {
    color: #6b7280;
}
.held-search-input {
    border: none;
    outline: none;
    width: 100%;
    background: transparent;
}
.held-legend {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--muted);
    font-size: 0.85rem;
    flex: 0 0 auto;
}
.legend-sep {
    opacity: 0.6;
}
.legend-dot {
    display: inline-block;
    width: 0.6rem;
    height: 0.6rem;
    border-radius: 50%;
    vertical-align: middle;
    margin-right: 0.25rem;
}
.legend-loaded {
    background: #34d399;
}
.legend-dinein {
    background: #60a5fa;
}
.legend-other {
    background: #fbbf24;
}

/* Count chip in title */
.held-count {
    background: #fff;
    border: 1px solid #dbeee3;
    font-weight: 800;
}

/* --- Empty state --- */
.held-empty {
    text-align: center;
    color: var(--muted);
    padding: 2.2rem 0;
    border: 2px dashed #e4f4ea;
    border-radius: 0.9rem;
    background: #fbfefd;
}
.held-empty-icon {
    font-size: 2rem;
    margin-bottom: 0.4rem;
    color: var(--brand);
}
.held-empty-title {
    font-weight: 800;
    color: var(--ink);
}
.held-empty-sub {
    font-size: 0.9rem;
}

/* --- Grid: max 2 columns --- */
.held-grid-modern {
    display: grid;
    gap: 0.75rem;
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
@media (max-width: 720px) {
    .held-grid-modern {
        grid-template-columns: 1fr;
    }
}

/* --- Card --- */
.held-card-modern {
    position: relative;
    background: #fff;
    border: 1.5px solid #e4f4ea;
    border-radius: 0.9rem;
    padding: 0.8rem 0.8rem 0.7rem;
    display: grid;
    gap: 0.45rem;
    transition: transform 0.18s ease, box-shadow 0.18s ease,
        border-color 0.18s ease;
    cursor: pointer;
}
.held-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 26px rgba(15, 139, 76, 0.12);
    border-color: #cde8d5;
}
.held-card-modern:focus-visible {
    outline: 3px solid var(--ring);
    outline-offset: 2px;
}

/* subtle colored accent bar on left by type */
.held-card-modern::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 5px;
    border-top-left-radius: inherit;
    border-bottom-left-radius: inherit;
    background: linear-gradient(180deg, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0));
}
.held-card-modern.is-dinein::before {
    background: linear-gradient(180deg, #60a5fa, #3b82f6);
}
.held-card-modern.is-other::before {
    background: linear-gradient(180deg, #fbbf24, #f59e0b);
}
.held-card-modern.is-loaded {
    border-color: #bfe7d2;
    background: linear-gradient(0deg, #ffffff 0%, #f7fcf9 100%);
    box-shadow: 0 8px 18px rgba(34, 197, 94, 0.15);
}

/* header row */
.held-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
}
.held-id {
    font-weight: 900;
    letter-spacing: 0.02em;
}
.held-type {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
    justify-content: flex-end;
}
.chip-type {
    border: 1px solid #e4f4ea;
    background: #f7fcf9;
    border-radius: 999px;
    padding: 0.1rem 0.5rem;
    font-size: 0.78rem;
    font-weight: 800;
}
.chip-loaded {
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
    color: #065f46;
    border-radius: 999px;
    padding: 0.1rem 0.5rem;
    font-size: 0.78rem;
    font-weight: 800;
}

/* meta row */
.held-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem 0.8rem;
    color: var(--muted);
}
.meta-dot {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}

/* items list */
.held-items {
    list-style: none;
    padding: 0;
    margin: 0.2rem 0 0;
    display: grid;
    gap: 0.25rem;
}
.held-item {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 0.5rem;
    border: 1px dashed #e4f4ea;
    background: #fff;
    border-radius: 0.6rem;
    padding: 0.35rem 0.5rem;
}
.held-item-name {
    font-weight: 800;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.held-item-qty {
    font-weight: 800;
    color: var(--ink);
}

/* actions row */
.held-actions-modern {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 0.35rem;
}
.ghost-spacer {
    flex: 1;
}
.cta-hint {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    color: var(--muted);
    font-size: 0.85rem;
}

/* footer */
.held-modal-footer {
    background: #f8fdfa;
    border-top: 1px solid var(--line);
}
/* Give header tools a little more air */
.header-tools {
    gap: 0.75rem;
}

/* a subtle divider so the tables control feels separated */
.tools-sep {
    display: inline-block;
    width: 1px;
    height: 28px;
    background: #e6f3ea;
    margin: 0 0.25rem;
}

/* bigger, friendlier table button */
.btn-circle {
    width: 40px;
    height: 40px;
}
.btn-circle-lg {
    width: 46px;
    height: 46px;
} /* ⬅️ new size */
.tables-toggle {
    display: flex;
    align-items: center;
    gap: 0.45rem;
}

/* clearer, tappable table status */
.table-chip {
    background: #fff;
    border: 1px solid #dbeee3;
    border-radius: 999px;
    padding: 0.2rem 0.55rem;
    font-size: 0.82rem;
    font-weight: 800;
    line-height: 1.1;
    min-width: 96px; /* stable width so layout doesn't jump */
    text-align: center;
    color: var(--ink);
}
/* cart head layout breathes & wraps nicely on small screens */
.cart-head {
    padding: 0.75rem 0.9rem;
    border-bottom: 1px solid var(--line);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.6rem;
    flex-wrap: wrap;
}

/* left side: icon chip + label */
.cart-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 0;
}
.cart-title-ico {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #ecfdf5;
    border: 1px solid #bbf7d0;
    color: #065f46;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.cart-title-text {
    font-weight: 900;
}

/* right side: tidy, equal-sized controls */
.cart-actions {
    display: flex;
    align-items: center;
    gap: 0.45rem;
}
.btn-ctl {
    border: 1.5px solid #e4f4ea;
    background: #fff;
    color: var(--ink);
    border-radius: 0.65rem;
    height: 38px;
    padding: 0 0.75rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    transition: 0.15s ease;
}
.btn-ctl:hover {
    background: #f7fcf9;
    border-color: #cde8d5;
}
.btn-ctl.danger {
    background: #fff5f5;
    border-color: #fde2e2;
    color: #991b1b;
}

.btn-ctl .count {
    margin-left: 0.35rem;
    font-size: 0.78rem;
    font-weight: 800;
    background: #fff;
    border: 1px solid #dbeee3;
    border-radius: 999px;
    padding: 0.05rem 0.45rem;
    line-height: 1;
}

/* small screens: make buttons fill nicely */
@media (max-width: 520px) {
    .cart-actions {
        width: 100%;
    }
    .btn-ctl {
        flex: 1;
        justify-content: center;
    }
}
/* Compact code-only staff picker */
.staff-grid-compact {
    margin-top: 0.5rem;
    display: grid;
    /* small min width = more per row; adjusts automatically */
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 0.5rem;
}

.staff-code-card {
    display: grid;
    place-items: center;
    padding: 0.55rem;
    border: 1px solid #e5e7eb;
    background: #fff;
    border-radius: 0.9rem;
    min-height: 56px; /* ≥44px tap target */
    cursor: pointer;
    touch-action: manipulation;
    transition: transform 0.05s ease, box-shadow 0.12s ease,
        border-color 0.12s ease;
    user-select: none;
}

.staff-code-card:active {
    transform: scale(0.992);
}
.staff-code-card.active {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.14);
}

.staff-code-card.is-disabled,
.staff-code-card[disabled] {
    opacity: 0.55;
    pointer-events: none;
}

.code-label {
    font-weight: 800;
    letter-spacing: 0.3px;
    font-size: 1rem; /* readable but compact */
    line-height: 1;
    white-space: nowrap;
}

.staff-empty {
    padding: 0.75rem;
}

/* Optional: denser layout on wide screens */
@media (min-width: 1200px) {
    .staff-grid-compact {
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    }
}

/* totals & discount spacing */
.tot-row {
    /* was: margin: 0.2rem 0; */
    margin: 0.45rem 0; /* more vertical rhythm */
}

.tot-row + .tot-row {
    margin-top: 0.6rem;
}

/* separate grand total visually */
.tot-row.grand {
    padding-top: 0.5rem;
    margin-top: 0.6rem;
    border-top: 1px dashed var(--line);
    font-size: 1.15rem;
    font-weight: 800;
}

/* add a touch of space around the discount input */
.cart-foot #discVal {
    margin-inline-start: 0.5rem;
}

/* keep the discount radio group from hugging labels */
#discType .btn {
    padding-inline: 0.6rem;
}

/* keep the existing two-column top row for name + qty */
.held-item {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: start;
    gap: 0.5rem;
    border: 1px dashed #e4f4ea;
    background: #fff;
    border-radius: 0.6rem;
    padding: 0.45rem 0.55rem;
}

/* name + qty on the first row */
.held-line-main {
    grid-column: 1 / -1; /* Let it define the row, then we place opts below */
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 0.5rem;
}

/* options block sits UNDER the first row, and spans full width */
.held-item-opts {
    grid-column: 1 / -1; /* ⬅️ full width under the item */
    margin-top: 0.15rem;
    color: var(--muted);
    font-size: 0.85rem;
    line-height: 1.35;
    white-space: normal;
    word-break: break-word;
}

/* each variation line (e.g., Size:, Toppings:) */
.held-opt-group + .held-opt-group {
    margin-top: 2px;
}

.held-opt-label {
    font-weight: 700;
    margin-right: 0.25rem;
}

/* inline options with bold dot separators */
.held-opt-values .held-val {
    display: inline;
}

.held-sep {
    font-weight: 900; /* bold dot */
    display: inline-block;
    margin: 0 0.35rem;
    line-height: 1;
}
.held-item-opts {
    border-top: 1px dashed #e4f4ea;
    padding-top: 0.25rem;
}
.held-item-opts {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
/* options block sits UNDER the first row, and spans full width */
.held-item-opts {
    grid-column: 1 / -1;
    margin-top: 0.15rem;
    color: var(--muted);
    font-size: 0.85rem;
    line-height: 1.35;
    white-space: normal;
    word-break: break-word;
}

/* each variation line (e.g., Size:, Toppings:) */
.held-opt-group + .held-opt-group {
    margin-top: 2px;
}

.held-opt-label {
    font-weight: 700;
    margin-right: 0.25rem;
}

/* render a bold dot BEFORE every value except the first */
.held-opt-values .held-val:not(:first-child)::before {
    content: "•";
    font-weight: 900;
    display: inline-block;
    margin: 0 0.35rem;
    line-height: 1;
}

/* ensure the top row (name + qty) then options below */
.held-item {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: start;
    gap: 0.5rem;
}

.held-line-main {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 0.5rem;
}
/* Put all variation groups on one row; wrap when needed */
.held-item-opts {
  grid-column: 1 / -1;
  margin-top: 0.15rem;
  color: var(--muted);
  font-size: 0.85rem;
  line-height: 1.35;
  display: flex;            /* ⬅️ was block/grid; now flex row */
  flex-wrap: wrap;          /* wrap to next line when tight */
  gap: 2px 10px;            /* row-gap, column-gap between groups */
  white-space: normal;
  word-break: break-word;
}

/* Each variation group (e.g., "Size: Large") sits inline */
.held-opt-group {
  display: inline-flex;     /* label + values stay together */
  align-items: baseline;
}

/* Bold dot between variation groups (not the first) */
.held-opt-group:not(:first-child)::before {
  content: "•";
  font-weight: 900;
  display: inline-block;
  margin: 0 0.4rem;
  line-height: 1;
}

/* Keep the label bold and tight to its values */
.held-opt-label {
  font-weight: 700;
  margin-right: 0.25rem;
}

/* Keep bold dot between option values inside the same group */
.held-opt-values .held-val:not(:first-child)::before {
  content: "•";
  font-weight: 900;
  display: inline-block;
  margin: 0 0.35rem;
  line-height: 1;
}

/* Remove old vertical stacking spacing, if you had it */
.held-opt-group + .held-opt-group {
  margin-top: 0; /* ⬅️ neutralize any previous vertical margin */
}

</style>
