<template>
    <div class="form-self-group" :key="selection.key">
        <div class="hospitals select-box">
            <div class="hospitals selected" :id="selection.key" :style="selection.disabled ? 'cursor: no-drop' : ''">
                <template v-if="selection.label != 'Silahkan Pilih'">
                    <span class="click-title"
                        :class="selection.label != 'Silahkan Pilih' ? 'select-title' : ''">
                        {{ selection.label }}
                    </span>
                    <span class="select-close" :class="'select-close-' + selection.class"
                        v-on:click="selectclear(selection.key)">&times;</span>
                </template>
                <template v-else>
                    <input
                        :id="'form_'+selection.key"
                        :name="'form_'+selection.key"
                        class="hospitals select-search-inline"
                        v-model="selection.search"
                        type="text"
                        :placeholder="'Pilih ' + selection.html + '...'"
                        :disabled="selection.disabled"
                        @keyup="onKeyup($event)"
                        @focus="$emit('focus', $event)"
                        autocomplete="off"
                    />
                </template>
            </div>
            <div class="hospitals options-container" :style="selection.option">
                <ul style="margin: 16px 0 0 0">
                    <template v-if="!selection.dosearch">
                        <li v-if="selection.filter.length > 0"
                            v-for="(item, index) in selection.filter"
                            :key="item.value"
                            v-on:click="selecteditem(item, index, selection.key)">
                            {{ item.label }}
                        </li>
                        <li v-else>No data for result</li>
                    </template>
                    <template v-else>
                        <li>Mohon Tunggu.....</li>
                    </template>
                </ul>
            </div>
        </div>
        <label :for="'form_'+selection.key" :class="selection.isrequired ? 'required' : ''">
            {{ selection.html }}
        </label>
    </div>
</template>

<script>
var vm;
export default {
    mounted:function() { vm = this; },
    emits: ["selecteditem", "selectclear", "keyup", "focus"],
    props: {
        selection: { type: Object },
        getbounding: { type: Function }
    },
    data: () => { return { } },
    methods: {
        onKeyup:function(event) {
            this.$emit('keyup', event);
        },

        selectclear:function(key) {
            if (vm.selection.disabled) { return ; }
            this.$emit('selectclear', key);
        },

        selecteditem:function(item, index, posisi) {
            this.$emit('selecteditem', item, posisi);
        },
    }
}
</script>

<style scoped>
.select-search-inline {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: inherit;
    color: inherit;
    cursor: text;
    padding: 0;
    margin: 0;
    height: 100%;
}
.select-search-inline:disabled {
    cursor: no-drop;
}
</style>