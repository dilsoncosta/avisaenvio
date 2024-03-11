<template>
	<Preloader/>
	<router-view/>
</template>
<style>
:root {
--ms-border-color: #ccc;
--ms-radius: 0px;
--ms-border-color-active: #ccc;
--ms-border-width-active: 1px;
--ms-line-height:2.0rem;
--ms-ring-color: #fff;
--ms-placeholder-color: #000000;
--ms-option-font-size: 0.8rem;
--ms-tag-font-size: .699rem;
--ms-option-bg-pointed:#337ab7;
--ms-option-color-pointed:#fff;
--ms-dropdown-bg:#fefac2;
--ms-option-py:.3rem;
--ms-tag-bg:#337ab7;
--ms-font-size:0.7rem;
--ms-line-height:2.6rem;
--ms-px:.40rem;
--ms-option-bg-disabled: #fefac2;
}

* {
	box-sizing: border-box;
}
body {
	background-color: #f3f4f6;
	font-family: 'Roboto', sans-serif;
}
#app {
	display:flex;
}
html, body, div, span, applet, object, iframe,h1, h2, h3, h4, h5, h6, p,
blockquote, pre,a, abbr, acronym, address, big, cite, code,del, dfn, em,
img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var,b, u,
i, center,dl, dt, dd, ol, ul, li,fieldset, form, label, legend,table,
caption, tbody, tfoot, thead, tr, th, td,article, aside, canvas, details,
embed, figure, figcaption, footer, header, hgroup, menu, nav, output,
ruby, section, summary, time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
}
.multiselect {
	min-height:33px !important;
	margin-top:6px !important;
}
.multiselect-dropdown {
	overflow-y: auto !important;
}
.quill-editor-heigth-one {
	height: 350px !important;
}
.quill-editor-heigth-two {
	height: 150px !important;
}
.multiselect-option span {
	font-size:10.5px;
}
.placeholder-card-kaban {
	background-color: rgba(33, 33, 33, 0.08) !important;
	border-radius:0.4rem;
	transform:scaleY(0.85);
	transform-origin:0% 0%;
	margin-top:0.8rem;
	padding:12px;
	margin-right:21px;
}
</style>
<style src="@vueform/multiselect/themes/default.css"></style>

