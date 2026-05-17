<template>
  <div class="on-wrap" :class="'on-depth-' + depth">
    <!-- Node card -->
    <div class="on-card" :class="node.active === 'Aktif' || node.active === true ? 'on-active' : 'on-inactive'">
      <div class="on-header">
        <div class="on-icon" :style="iconStyle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <div class="on-info">
          <div class="on-name">{{ node.nama }}</div>
          <div class="on-meta">
            <span class="on-badge" :class="node.active === 'Aktif' || node.active === true ? 'badge-green' : 'badge-gray'">
              {{ node.active === 'Aktif' || node.active === true ? 'Aktif' : 'Tidak Aktif' }}
            </span>
            <span class="on-type">{{ node.tipe_code || node.tipe }}</span>
            <span class="on-kode" v-if="node.kode">{{ node.kode }}</span>
          </div>
          <div class="on-id" :title="node.satusehat_id">{{ shortId(node.satusehat_id) }}</div>
        </div>
        <button v-if="hasChildren" @click="expanded = !expanded" class="on-toggle" :title="expanded ? 'Tutup' : 'Buka'">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="expanded ? 'chevron-up' : ''"><polyline points="6 9 12 15 18 9"/></svg>
          <span>{{ childCount }}</span>
        </button>
      </div>

      <!-- Telecom row -->
      <div class="on-footer" v-if="node.telepon && node.telepon !== '-'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="on-fc-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.38 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 5.55 5.55l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        {{ node.telepon }}
      </div>
    </div>

    <!-- Children -->
    <transition name="chart-expand">
      <div class="on-children" v-if="hasChildren && expanded">
        <div class="on-branch-line"></div>
        <div class="on-children-row">
          <OrgNode
            v-for="child in children"
            :key="child.satusehat_id"
            :node="child"
            :children-map="childrenMap"
            :depth="depth + 1"
          />
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
const DEPTH_COLORS = ['#1c84ee', '#0d9488', '#7c3aed', '#ea580c', '#be123c', '#15803d'];

export default {
  name: 'OrgNode',
  props: {
    node:        { type: Object,  required: true },
    childrenMap: { type: Object,  required: true },
    depth:       { type: Number,  default: 0 },
  },
  data() {
    return { expanded: true };
  },
  computed: {
    children()    { return this.childrenMap[this.node.satusehat_id] ?? []; },
    hasChildren() { return this.children.length > 0; },
    childCount()  { return this.children.length; },
    iconStyle()   {
      const color = DEPTH_COLORS[this.depth % DEPTH_COLORS.length];
      return { background: color + '18', '--icon-color': color };
    },
  },
  methods: {
    shortId(id) {
      if (!id) return '—';
      return id.length > 16 ? id.slice(0, 8) + '…' + id.slice(-6) : id;
    },
  },
};
</script>

<style scoped>
.on-wrap { display: flex; flex-direction: column; align-items: center; }

/* Card */
.on-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  min-width: 200px;
  max-width: 240px;
  box-shadow: 0 1px 4px rgba(0,0,0,.06);
  transition: box-shadow .15s, border-color .15s;
  overflow: hidden;
}
.on-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.10); border-color: #93c5fd; }
.on-active   { border-color: #bfdbfe; }
.on-inactive { border-color: #fee2e2; opacity: .8; }

/* Header */
.on-header { display: flex; align-items: flex-start; gap: 10px; padding: 12px 12px 8px; }
.on-icon {
  width: 36px; height: 36px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.on-icon svg { width: 18px; height: 18px; stroke: var(--icon-color, #1c84ee); }

.on-info { flex: 1; min-width: 0; }
.on-name { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.3; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.on-meta { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; margin-bottom: 4px; }
.on-badge { font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 20px; }
.badge-green { background: #dcfce7; color: #16a34a; }
.badge-gray  { background: #f1f5f9; color: #64748b; }
.on-type { font-size: 10px; background: #dbeafe; color: #1d4ed8; border-radius: 4px; padding: 1px 5px; font-weight: 600; }
.on-kode { font-size: 10px; background: #f1f5f9; color: #64748b; border-radius: 4px; padding: 1px 5px; font-family: monospace; }
.on-id   { font-size: 10px; color: #94a3b8; font-family: monospace; }

/* Toggle expand button */
.on-toggle {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 3px 7px;
  display: flex; align-items: center; gap: 3px;
  cursor: pointer;
  font-size: 11px;
  color: #64748b;
  white-space: nowrap;
  flex-shrink: 0;
}
.on-toggle:hover { background: #dbeafe; border-color: #93c5fd; color: #1c84ee; }
.on-toggle svg { width: 13px; height: 13px; transition: transform .2s; }
.chevron-up { transform: rotate(180deg); }

/* Footer */
.on-footer {
  display: flex; align-items: center; gap: 5px;
  padding: 5px 12px 8px;
  font-size: 11px; color: #64748b;
  border-top: 1px solid #f1f5f9;
}
.on-fc-icon { width: 12px; height: 12px; stroke: #94a3b8; flex-shrink: 0; }

/* Children / tree lines */
.on-children { display: flex; flex-direction: column; align-items: center; padding-top: 0; }
.on-branch-line { width: 2px; height: 20px; background: #cbd5e1; }
.on-children-row { display: flex; gap: 20px; align-items: flex-start; position: relative; padding: 0 10px; }
.on-children-row::before {
  content: '';
  position: absolute;
  top: 0;
  left: 10px;
  right: 10px;
  height: 2px;
  background: #cbd5e1;
}

/* Expand transition */
.chart-expand-enter-active, .chart-expand-leave-active { transition: opacity .2s, max-height .25s; max-height: 2000px; overflow: hidden; }
.chart-expand-enter-from, .chart-expand-leave-to { opacity: 0; max-height: 0; }
</style>
