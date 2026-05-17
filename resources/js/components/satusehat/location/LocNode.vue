<template>
  <div class="ln-wrap" :class="'ln-depth-' + depth">
    <!-- Node card -->
    <div class="ln-card" :class="statusClass">
      <div class="ln-header">
        <div class="ln-icon" :style="iconStyle">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
            <circle cx="12" cy="10" r="3"/>
          </svg>
        </div>
        <div class="ln-info">
          <div class="ln-name">{{ node.nama }}</div>
          <div class="ln-meta">
            <span class="ln-badge" :class="statusBadgeClass">{{ statusLabel }}</span>
            <span class="ln-tipe" v-if="nodeTipeFisik">{{ nodeTipeFisik }}</span>
            <span class="ln-kode" v-if="node.kode && node.kode !== '-'">{{ node.kode }}</span>
            <span class="ln-sc" v-if="node.service_class && node.service_class !== '-'">{{ node.service_class }}</span>
          </div>
          <div class="ln-id" :title="node.satusehat_id">{{ shortId(node.satusehat_id) }}</div>
        </div>
        <button v-if="hasChildren" @click="expanded = !expanded" class="ln-toggle" :title="expanded ? 'Tutup' : 'Buka'">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" :class="expanded ? 'chevron-up' : ''"><polyline points="6 9 12 15 18 9"/></svg>
          <span>{{ childCount }}</span>
        </button>
      </div>

      <!-- Telecom row -->
      <div class="ln-footer" v-if="node.telepon && node.telepon !== '-'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="ln-fc-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.6 3.38 2 2 0 0 1 3.58 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.54a16 16 0 0 0 5.55 5.55l.92-.92a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        {{ node.telepon }}
      </div>
    </div>

    <!-- Children -->
    <transition name="chart-expand">
      <div class="ln-children" v-if="hasChildren && expanded">
        <div class="ln-branch-line"></div>
        <div class="ln-children-row">
          <LocNode
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
const DEPTH_COLORS = ['#0f766e', '#0891b2', '#7c3aed', '#ea580c', '#be123c', '#15803d'];

export default {
  name: 'LocNode',
  props: {
    node:        { type: Object, required: true },
    childrenMap: { type: Object, required: true },
    depth:       { type: Number, default: 0 },
  },
  data() { return { expanded: true }; },
  computed: {
    children()    { return this.childrenMap[this.node.satusehat_id] ?? []; },
    hasChildren() { return this.children.length > 0; },
    childCount()  { return this.children.length; },
    iconStyle() {
      const color = DEPTH_COLORS[this.depth % DEPTH_COLORS.length];
      return { background: color + '18', '--icon-color': color };
    },
    statusLabel() {
      const s = (this.node.status || '').toLowerCase();
      if (s === 'active')    return 'Active';
      if (s === 'inactive')  return 'Inactive';
      if (s === 'suspended') return 'Suspended';
      return this.node.status || '—';
    },
    statusClass() {
      const s = (this.node.status || '').toLowerCase();
      if (s === 'active')    return 'ln-active';
      if (s === 'inactive')  return 'ln-inactive';
      if (s === 'suspended') return 'ln-suspended';
      return '';
    },
    statusBadgeClass() {
      const s = (this.node.status || '').toLowerCase();
      if (s === 'active')    return 'badge-green';
      if (s === 'inactive')  return 'badge-red';
      if (s === 'suspended') return 'badge-yellow';
      return 'badge-gray';
    },
    nodeTipeFisik() {
      const t = this.node.tipe_fisik || '';
      return (t && t !== '-') ? t : '';
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
.ln-wrap { display: flex; flex-direction: column; align-items: center; }

/* Card */
.ln-card {
  background: #fff;
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  min-width: 200px;
  max-width: 240px;
  box-shadow: 0 1px 4px rgba(0,0,0,.06);
  transition: box-shadow .15s, border-color .15s;
  overflow: hidden;
}
.ln-card:hover     { box-shadow: 0 4px 16px rgba(0,0,0,.10); border-color: #5eead4; }
.ln-active         { border-color: #99f6e4; }
.ln-inactive       { border-color: #fecaca; opacity: .8; }
.ln-suspended      { border-color: #fde68a; opacity: .85; }

/* Header */
.ln-header { display: flex; align-items: flex-start; gap: 10px; padding: 12px 12px 8px; }
.ln-icon {
  width: 36px; height: 36px;
  border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  flex-shrink: 0;
}
.ln-icon svg { width: 18px; height: 18px; stroke: var(--icon-color, #0f766e); }

.ln-info { flex: 1; min-width: 0; }
.ln-name { font-size: 13px; font-weight: 700; color: #1e293b; line-height: 1.3; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ln-meta { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; margin-bottom: 4px; }
.ln-badge  { font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 20px; }
.badge-green  { background: #dcfce7; color: #16a34a; }
.badge-red    { background: #fee2e2; color: #dc2626; }
.badge-yellow { background: #fef9c3; color: #ca8a04; }
.badge-gray   { background: #f1f5f9; color: #64748b; }
.ln-tipe  { font-size: 10px; background: #ccfbf1; color: #0f766e; border-radius: 4px; padding: 1px 5px; font-weight: 600; }
.ln-kode  { font-size: 10px; background: #f1f5f9; color: #64748b; border-radius: 4px; padding: 1px 5px; font-family: monospace; }
.ln-sc    { font-size: 10px; background: #ede9fe; color: #5b21b6; border-radius: 4px; padding: 1px 5px; font-weight: 700; }
.ln-id    { font-size: 10px; color: #94a3b8; font-family: monospace; }

/* Toggle expand button */
.ln-toggle {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  padding: 3px 7px;
  display: flex; align-items: center; gap: 3px;
  cursor: pointer; font-size: 11px; color: #64748b;
  white-space: nowrap; flex-shrink: 0;
}
.ln-toggle:hover { background: #ccfbf1; border-color: #5eead4; color: #0f766e; }
.ln-toggle svg { width: 13px; height: 13px; transition: transform .2s; }
.chevron-up { transform: rotate(180deg); }

/* Footer */
.ln-footer {
  display: flex; align-items: center; gap: 5px;
  padding: 5px 12px 8px;
  font-size: 11px; color: #64748b;
  border-top: 1px solid #f1f5f9;
}
.ln-fc-icon { width: 12px; height: 12px; stroke: #94a3b8; flex-shrink: 0; }

/* Children / tree lines */
.ln-children { display: flex; flex-direction: column; align-items: center; }
.ln-branch-line { width: 2px; height: 20px; background: #cbd5e1; }
.ln-children-row { display: flex; gap: 20px; align-items: flex-start; position: relative; padding: 0 10px; }
.ln-children-row::before {
  content: ''; position: absolute; top: 0;
  left: 10px; right: 10px;
  height: 2px; background: #cbd5e1;
}

/* Expand transition */
.chart-expand-enter-active, .chart-expand-leave-active { transition: opacity .2s, max-height .25s; max-height: 2000px; overflow: hidden; }
.chart-expand-enter-from, .chart-expand-leave-to { opacity: 0; max-height: 0; }
</style>
