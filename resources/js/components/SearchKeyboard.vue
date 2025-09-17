<template>
  <div class="kb-tray" :dir="rtl ? 'rtl' : 'ltr'" role="group" aria-label="On-screen keyboard">
    <!-- Row 1 -->
    <div class="kb-row">
      <button
        v-for="k in (symbols ? symRow1 : row1)"
        :key="'r1-'+k"
        type="button"
        class="kb-key"
        @pointerdown.stop.prevent="tapKey(k)"
      >
        {{ keyLabel(k) }}
      </button>
    </div>

    <!-- Row 2 -->
    <div class="kb-row">
      <button
        v-for="k in (symbols ? symRow2 : row2)"
        :key="'r2-'+k"
        type="button"
        class="kb-key"
        @pointerdown.stop.prevent="tapKey(k)"
      >
        {{ keyLabel(k) }}
      </button>
    </div>

    <!-- Row 3 -->
    <div class="kb-row">
      <button
        v-if="!symbols"
        type="button"
        class="kb-key kb-wide"
        :aria-pressed="shift ? 'true' : 'false'"
        @pointerdown.stop.prevent="toggleShift"
        title="Shift"
      >
        <i class="fa-solid fa-arrow-up-wide-short"></i>
      </button>

      <button
        v-for="k in (symbols ? symRow3 : row3)"
        :key="'r3-'+k"
        type="button"
        class="kb-key"
        @pointerdown.stop.prevent="tapKey(k)"
      >
        {{ keyLabel(k) }}
      </button>

      <button
        type="button"
        class="kb-key kb-wide"
        title="Backspace"
        @pointerdown.stop.prevent="startErase"
        @pointerup.stop.prevent="stopErase"
        @pointerleave.stop.prevent="stopErase"
        @pointercancel.stop.prevent="stopErase"
      >
        <i class="fa-solid fa-delete-left"></i>
      </button>
    </div>

    <!-- Row 4 / controls -->
    <div class="kb-row">
      <button
        type="button"
        class="kb-key kb-wide"
        @pointerdown.stop.prevent="toggleSymbols"
      >
        {{ symbols ? 'ABC' : '123' }}
      </button>

      <button
        type="button"
        class="kb-key kb-xwide"
        aria-label="Space"
        @pointerdown.stop.prevent="tapKey(' ')"
      >
        Space
      </button>

      <button
        type="button"
        class="kb-key"
        title="Clear"
        @pointerdown.stop.prevent="clearAll"
      >
        <i class="fa-solid fa-broom"></i>
      </button>

      <button
        type="button"
        class="kb-key kb-accent"
        title="Search / Enter"
        @pointerdown.stop.prevent="$emit('enter')"
      >
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchKeyboard",
  props: {
    modelValue: { type: String, default: "" }, // v-model
    rtl: { type: Boolean, default: false },
    autoUnshift: { type: Boolean, default: true }, // turn off Shift after a letter
  },
  emits: ["update:modelValue", "enter"],
  data() {
    return {
      shift: false,
      symbols: false,
      eraser: null,

      // local buffer to avoid stale prop reads
      localVal: this.modelValue || "",

      // letter layout
      row1: ["q", "w", "e", "r", "t", "y", "u", "i", "o", "p"],
      row2: ["a", "s", "d", "f", "g", "h", "j", "k", "l"],
      row3: ["z", "x", "c", "v", "b", "n", "m", ".", "-"],

      // symbol/number layout
      symRow1: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0"],
      symRow2: ["@", "#", "$", "_", "&", "-", "+", "(", ")", "/"],
      symRow3: ["*", "\"", "'", ":", ";", "!", "?", ".", ","],
    };
  },
  watch: {
    // keep local buffer in sync when parent changes value externally
    modelValue(val) {
      if (val !== this.localVal) this.localVal = val || "";
    },
  },
  methods: {
    keyLabel(k) {
      if (this.symbols) return k;
      const isLetter = /^[a-z]$/i.test(k);
      return isLetter && this.shift ? k.toUpperCase() : k;
    },
    commit(val) {
      this.localVal = val;
      this.$emit("update:modelValue", this.localVal);
    },
    tapKey(k) {
      const ch = this.keyLabel(k);
      this.commit((this.localVal || "") + ch);

      if (this.autoUnshift && this.shift && /^[a-z]$/i.test(k) && !this.symbols) {
        this.shift = false;
      }
    },
    toggleShift() {
      this.shift = !this.shift;
    },
    toggleSymbols() {
      this.symbols = !this.symbols;
      if (this.symbols) this.shift = false;
    },
    eraseOnce() {
      if (!this.localVal) return;
      this.commit(this.localVal.slice(0, -1));
    },
    startErase() {
      this.eraseOnce();
      if (this.eraser) clearInterval(this.eraser);
      this.eraser = setInterval(this.eraseOnce, 80);
    },
    stopErase() {
      if (this.eraser) {
        clearInterval(this.eraser);
        this.eraser = null;
      }
    },
    clearAll() {
      this.commit("");
    },
  },
  beforeUnmount() {
    this.stopErase();
  },
};
</script>

<style scoped>
.kb-tray {
  display: grid;
  gap: 0.4rem;
  padding: 0.5rem;
  border: 1px solid var(--line, #e5e7eb);
  background: var(--card, #fff);
  border-radius: 0.75rem;
  box-shadow: 0 8px 24px rgba(0,0,0,0.06);
  user-select: none;
  touch-action: manipulation;
}

.kb-row {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: 1fr;
  gap: 0.35rem;
}

.kb-key {
  font: inherit;
  font-weight: 800;
  border: 1px solid var(--line, #e5e7eb);
  background: #f9fafb;
  border-radius: 0.6rem;
  padding: 0.6rem 0.4rem;
  line-height: 1;
  min-height: 42px;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0,0,0,0.04);
  transition: transform .06s ease, box-shadow .12s ease, background .12s ease;
}

.kb-key:active {
  transform: translateY(1px);
}

.kb-wide { grid-column: span 1; min-width: 64px; }
.kb-xwide { grid-column: span 4; }

.kb-accent {
  background: var(--brand, #22c55e);
  color: #fff;
  border-color: transparent;
}

.kb-accent:active { filter: brightness(0.95); }
.kb-key i { font-size: 1rem; }

@media (max-width: 480px) {
  .kb-key { min-height: 40px; padding: 0.5rem 0.35rem; }
  .kb-xwide { grid-column: span 3; }
}
</style>
