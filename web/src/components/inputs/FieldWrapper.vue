<template>
	<label v-if="comLabel" :class="{ 'selecionar-serventia': label === 'Selecionar Serventia', 'checkbox': checkbox, 'bolder-label':bolderLabel, 'disabled':disabled, 'date-field':dateField, 'dark-theme':$vuetify.theme.dark}">
		<span class="label-wrapper">
			<template v-if="label">
				<span >{{ label }}</span>
				<v-tooltip v-if="tooltip" right>
					<template v-slot:activator="{ on, attrs }">
						<v-icon dark x-small color="primary" class="tooltip-activator" v-bind="attrs" v-on="on">mdi-information-outline</v-icon>
					</template>
					<span>{{tooltip}}</span>
				</v-tooltip>
			</template>
			<template v-if="comEspacoNoLabel">
				&nbsp;
			</template>
		</span>
		<slot />
	</label>
	<span :class="{ 'selecionar-serventia': label === 'Selecionar Serventia','checkbox': checkbox, 'bolder-label':bolderLabel, 'disabled':disabled, 'date-field':dateField,'label-wrapper':true, 'dark-theme':$vuetify.theme.dark}" v-else>
		<span >
			<template v-if="label">
				{{ label }}
			</template>
			<template v-if="comEspacoNoLabel">
				&nbsp;
			</template>
		</span>
		<slot />
	</span>
</template>

<script>
	export default {
		name: "FieldWrapper",
		props: {
			label: String,
			tooltip: String,
			checkbox: Boolean,
			disabled: Boolean,
			comLabel: {
				type:Boolean,
				default:true
			},
			bolderLabel: Boolean,
			comEspacoNoLabel: {
				type: Boolean,
				default: true
			},
			dateField: {
				type: Boolean,
				default: false
			},
		}
	};
</script>

<style scoped>
* label::v-deep:not(.checkbox) {
	width: 100%;
}

* label::v-deep:not(.checkbox) input{
	padding: 0 2px;
}

* label::v-deep .tooltip-activator{
	cursor: pointer;
}



* label::v-deep span.label-wrapper,
* >>> .v-label {
	display: flex;
	width: 100%;
	font-family: 'Inter';
	color: var(--dark);
	font-style: normal;
	font-weight: 400;
	font-size: 12px;
	text-align: left;
	word-wrap: break-word;
}

* label::v-deep .v-text-field fieldset {
	border: 1px solid currentColor;
}
* label::v-deep .v-text-field--outlined:not(.error--text) fieldset {
	border: 1px solid var(--gray500);
}
*
	label::v-deep
	.v-text-field--outlined.v-input--is-focused:not(.error--text)
	fieldset {
	border: 1px solid var(--gray500);
}

* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--single-line > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined.v-text-field--filled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--single-line > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined.v-text-field--filled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--single-line > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined.v-text-field--filled > .v-input__control > .v-input__slot{
    min-height: 20px;
		padding:2px;
}

* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot{
		background: var(--gray300);
    min-height: 20px;
		padding:2px;
}

* label.dark-theme::v-deep .v-text-field--filled.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--filled.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--full-width.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--full-width.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--outlined.v-input--dense.v-text-field--single-line.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined.v-input--is-disabled > .v-input__control > .v-input__slot,
* label.dark-theme::v-deep .v-text-field--outlined.v-input--dense.v-text-field--outlined.v-text-field--filled.v-input--is-disabled > .v-input__control > .v-input__slot{
		background: var(--gray700);
    min-height: 20px;
		padding:2px;
}

* label::v-deep .v-text-field--full-width.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__prepend-outer,
* label::v-deep .v-text-field--full-width.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__prepend-inner,
* label::v-deep .v-text-field--full-width.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__append-inner,
* label::v-deep .v-text-field--full-width.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__append-outer,
* label::v-deep .v-text-field--enclosed.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__prepend-outer,
* label::v-deep .v-text-field--enclosed.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__prepend-inner,
* label::v-deep .v-text-field--enclosed.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__append-inner,
* label::v-deep .v-text-field--enclosed.v-input--dense:not(.v-text-field--solo).v-text-field--outlined .v-input__append-outer{
	margin-top: auto;
  margin-bottom: auto;
}
* label::v-deep .v-icon{
	font-size:18px;
}
* label::v-deep .v-input,
* label::v-deep .v-text-field input {
	font-size: 12px;
	line-height: 16px;
}
* label::v-deep .checkbox .v-input--selection-controls__input,
* label::v-deep .v-input__icon {
	height: 18px;
}
* label::v-deep .v-text-field .v-input__append-inner{
	padding-left: 0;
}
* label::v-deep .v-icon__svg {
	min-width: 12px;
	width: 12px;
	height: 12px;
}


* label::v-deep .v-input--selection-controls__input {
	min-width: 14px;
	width: 14px;
	height: 14px;
	margin-right: 2px;
}
* label::v-deep .v-input__icon{
	min-width: 14px;
	width: 14px;
	height: 14px;

}

* label::v-deep .theme--light.v-input--checkbox.v-input--is-disabled{
	color: inherit!important;
}

* label::v-deep .v-text-field.v-text-field--enclosed .v-text-field__details{
	margin-bottom: 0;
}
* label::v-deep .v-input--selection-controls{
	padding-top: 0;
}
* label::v-deep .v-autocomplete.v-select.v-input--is-focused input{
	min-width: 50px;
}
* label::v-deep .v-autocomplete .v-input__icon.v-input__icon--clear{
	min-width: 12px;
	width: 12px;
}

* label.disabled::v-deep, * label.disabled::v-deep > div:not(.v-input--checkbox){
	cursor:not-allowed!important;
}
* label.disabled::v-deep input {
	cursor:not-allowed!important;
	color: black!important;
}


* label.selecionar-serventia.disabled::v-deep span.label-wrapper {
	background: var(--disabledNotas) !important;
}

* label.selecionar-serventia.disabled::v-deep span .label-wrapper{
}

* label.dark-theme.disabled::v-deep input {
	cursor:not-allowed!important;
	color: white!important;
}

* label.disabled.checkbox::v-deep {
	cursor:not-allowed!important;
	background: transparent!important;

}

* label::v-deep .v-text-field__prefix,* label::v-deep .v-text-field__suffix{
	line-height: 16px!important;
}
* label.checkbox::v-deep .v-input--switch .v-input--switch__thumb{
    width: 12px;
    height: 12px;
		margin-top: 3px;
}
* label.dark-theme.checkbox::v-deep .v-input--switch .v-input--switch__thumb,
* label.dark-theme.checkbox::v-deep .v-input--switch .v-input--switch__track{
	color: white!important;

	border-color: white!important;
}

* label.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-input--switch__thumb,
* label.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-input--switch__track,
* label.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-label{
	color: var(--primary)!important;
	border-color:  var(--primary)!important;
}

* label.dark-theme.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-input--switch__thumb,
* label.dark-theme.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-input--switch__track,
* label.dark-theme.checkbox::v-deep .v-input--is-label-active .v-label,
* label.dark-theme.checkbox::v-deep .v-input--is-label-active .v-input--selection-controls__input .v-icon,
* label.dark-theme.checkbox::v-deep .v-input--switch.v-input--is-label-active .v-label{
	color: var(--primary2)!important;
	border-color:  var(--primary2)!important;
}

* label.dark-theme.disabled.checkbox::v-deep .v-input--switch.v-input--is-disabled:not(.v-input--is-dirty) .v-input--switch__thumb{
	color: white;

}
* label.dark-theme.disabled.checkbox::v-deep .v-input--switch.v-input--is-disabled:not(.v-input--is-dirty) .v-input--switch__thumb,
* label.dark-theme.disabled.checkbox::v-deep .v-input--switch.v-input--is-disabled:not(.v-input--is-dirty) .v-input--switch__track{

	opacity: 0.5!important;
}

* label::v-deep .v-select.v-text-field--outlined:not(.v-text-field--single-line).v-input--dense .v-select__selections{
	height: 20px;
	padding: 0;
}
* label::v-deep .v-select.v-input--dense .v-select__selection--comma{
	margin: 0;
}
* label::v-deep .v-select.v-select--is-multi .v-input__slot{
	padding: 0 2px!important;
}
</style>
