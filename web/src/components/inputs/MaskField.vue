<template>
  <FieldWrapper :label="label" v-bind="$attrs">
    <v-text-field
      v-model="internalValue"
      outlined
      dense
      hide-details="auto"
      v-mask="selectedMask"
      v-bind="$attrs"
      v-on="$listeners"
    />
  </FieldWrapper>
</template>

<script>
import FieldWrapper from "@/components/inputs/FieldWrapper.vue";
import * as masksObject from "@/util/masks.js";

export default {
  name: "MaskField",
  components: { FieldWrapper },
  props: {
    label: String,
    mask: [String, Array],
    modelValue: String
  },
  emits: ["update:modelValue"],
  computed: {
    selectedMask() {
      if (!this.mask) return null;
      if (/^[a-zA-Z]+$/.test(this.mask) && masksObject[this.mask]) {
        return masksObject[this.mask];
      }
      return this.mask;
    }
  },
  data() {
    return {
      internalValue: this.modelValue
    };
  },
  watch: {
    modelValue(val) {
      this.internalValue = val;
    },
    internalValue(val) {
      this.$emit("update:modelValue", val);
    }
  }
};
</script>
