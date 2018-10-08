<link href="css/index.php" rel="stylesheet" type="text/css" />
<style type="text/css">
div.file{width:<?php echo $this->config['thumbWidth'] ?>px;}
div.file .thumb{width:<?php echo $this->config['thumbWidth'] ?>px;height:<?php echo $this->config['thumbHeight'] ?>px}
</style>
<link href="themes/<?php echo $this->config['theme'] ?>/css.php" rel="stylesheet" type="text/css" />
<style>
    body{
        background-color:white;
    }
    #files, #folders {
        border: none;
        box-shadow: none;
        border-radius: 0px;
        background: #fff;
    }
    
    span.current {
        transition: .3s;
        background-image: url(img/tree/folder.png);
        background-color: none;
        border-color: transparent;
        box-shadow: none;
    }
    
    #toolbar a:hover, #toolbar a.hover, span.current, span.regular:hover, span.context, #clipboard div:hover, div.file:hover, #files div.selected, #files div.selected:hover, tr.selected>td, tr.selected:hover>td, #menu .list div a:hover, #toolbar a.selected, #files div {
        color: #333;
        text-shadow: none;
    }
    
    #files div.selected, #files div.selected:hover {
        border-color: transparent;
        background: #4685b3;
        box-shadow: none;
        color: white;
    }
    
    div.file {
        width: 125px;
        text-align: center;
        padding-bottom: 15px;
        border-radius: 3px;
        color: #333;
    }
    
    div.file:hover {
        box-shadow: none;
        background: #4685b3;
        border-color: #4685b3;
        color: white !important;
    }
    div.file:hover .name, div.file:hover .time, div.file:hover .size {
        color: white !important;
    }
    
    div.file .thumb {
        width: 100%;
        height: 125px;
    }
    div.time, div.size {
        display: block;
    }
    div.file .name {
        font-size: 12px;
    }
    
    
    #files div {
        -webkit-transition: all .1s;
        /* Safari */
        transition: all .1s;
        
    }
    
    #left {
        display: none !important;
    }
    #right, div#files {
        width: 100% !important;
    }
    
    #toolbar a:hover, #toolbar a.hover {
        color: #fff;
        background: #539612;
        border-color: #539612;
        box-shadow: none;
        transition: .1s
    }
    #toolbar a {
        transition: .1s
    }
    
    .ui-accordion-content-active, .ui-tabs, .ui-slider-range, .ui-datepicker, .ui-dialog {
        border: none;
    }
    .ui-widget-content {
        border: none;
        background: #fff;
    }
    
    .ui-widget-header, .ui-menu-item .ui-state-focus {
        box-shadow: none;
    }
    
    .ui-widget-header {
        border: none;
        color: #fff;
        font-weight: bold;
        background: #539612;
    }
    
    .ui-state-default, .ui-state-focus, .ui-state-active, .ui-widget-header, fieldset.sh-uniform label, fieldset.sh-uniform legend {
        text-shadow: none;
    }
    
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-widget.ui-state-disabled {
        transition: .1s;
        border: 1px solid #539612;
        background: #539612;
        color: #fff
    }
    .ui-state-default:hover, .ui-widget-content .ui-state-default:hover, .ui-widget-header .ui-state-default:hover, .ui-widget.ui-state-disabled:hover {
        background: #fff;
        color: #539612
    }
    .ui-dialog-buttonpane {
        background: #fff;
        box-shadow: none;
        border-top-color: #4d637c;
        margin: 0 -4px -4px -4px;
        padding: 0;
    }
    
    input.uniform-input, select.uniform-multiselect, textarea.uniform, div.uploader span.filename, div.selector span {
        border-color: #333 !important;
        box-shadow: none !important;
        background: #fff !important;
        color: #aaa !important;
        border-radius: 3px !important;
    }
    .ui-button {
        box-shadow: none;
    }
    
    .ui-progressbar, .ui-slider, .ui-menu {
        -webkit-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        -moz-box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        background: #fff;
    }
    
    fieldset.sh-uniform {
        color: #333;
        border: 1px solid #539612;
        border-radius: 4px;
        background: #fff;
        box-shadow: none;
        margin: 0 10px 10px 0;
        padding: 10px
    }
    
    div.selector, div.button, div.uploader span.action, div.radio, div.checker {
        border-color: #539612;
        background: white;
        box-shadow: none
    }
    
    #toolbar a.selected {
        color: #aaa;
        border: 1px solid #539612;
        border-radius: 4px;
        background: #539612;
        box-shadow: none
    }
    
    #toolbar a:hover, #toolbar a.hover, span.current, span.regular:hover, span.context, #clipboard div:hover, div.file:hover, #files div.selected, #files div.selected:hover, tr.selected>td, tr.selected:hover>td, #menu .list div a:hover, #toolbar a.selected {
        color: #fff !important;
    }
    
    #settings {
        padding: 10px 0px;
    }
    
</style>