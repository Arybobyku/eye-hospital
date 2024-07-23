<template>
  <div>
    <div v-if="disabled == false">
      <vueSignature
        ref="signature"
        :sigOption="option"
        :disabled="disabled"
      ></vueSignature>
    </div>
    <div v-if="disabled == true && digitalSignatureResult != '' ">
      <img :src="digitalSignatureResult" alt="Digital Signature Result">
    </div>
    <br />
    <div v-if="disabled == false">
      <button class="tooltip btn-success" @click="save">Simpan</button>
      <button class="tooltip btn-danger" @click="clear">Hapus</button>
    </div>
    <div v-if="disabled">
      <button class="tooltip btn-success" @click="handleDisabled">Ubah</button>
    </div>
  </div>
</template>
<script>
import vueSignature from "vue-signature";
export default {
  name: "DigitalSignature",
  components: {
    vueSignature,
  },
  data() {
    return {
      option: {
        penColor: "rgb(0, 0, 0)",
        backgroundColor: "rgb(240,240,240)",
      },
      disabled: true,
      dataUrl: "https://avatars2.githubusercontent.com/u/17644818?s=460&v=4",
      digitalSignatureResult: "",
    };
  },
  methods: {
    save() {
      var _this = this;
      var svg = _this.$refs.signature.save("image/svg+xml");
      _this.digitalSignatureResult = svg;
      _this.$emit("onSaveDigitalSignature", svg);
      _this.handleDisabled();
    },
    clear() {
      var _this = this;
      _this.$refs.signature.clear();
    },
    undo() {
      var _this = this;
      _this.$refs.signature.undo();
    },
    addWaterMark() {
      var _this = this;
      _this.$refs.signature.addWaterMark({
        text: "mark text", // watermark text, > default ''
        font: "20px Arial", // mark font, > default '20px sans-serif'
        style: "all", // fillText and strokeText,  'all'/'stroke'/'fill', > default 'fill
        fillStyle: "red", // fillcolor, > default '#333'
        strokeStyle: "blue", // strokecolor, > default '#333'
        x: 100, // fill positionX, > default 20
        y: 200, // fill positionY, > default 20
        sx: 100, // stroke positionX, > default 40
        sy: 200, // stroke positionY, > default 40
      });
    },
    fromDataURL(url) {
      var _this = this;
      _this.$refs.signature.fromDataURL("data:image/png;base64,iVBORw0K...");
    },
    handleDisabled() {
      var _this = this;
      _this.disabled = !_this.disabled;
    },
  },
};
</script>
