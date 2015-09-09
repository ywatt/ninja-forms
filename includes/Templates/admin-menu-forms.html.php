 <style>
    .toplevel_page_ninja-forms-3-0 #wpfooter {
        display: none;
    }
    .toplevel_page_ninja-forms-3-0 #wpcontent {
        background: #fff;
        margin-left: 140px;
    }
    .toplevel_page_ninja-forms-3-0.folded #wpcontent {
        margin-left: 16px;
    }
    .toplevel_page_ninja-forms-3-0 #wpcontent #wpbody {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 160px;
    }
    .toplevel_page_ninja-forms-3-0.folded #wpcontent #wpbody {
        left: 36px;
    }
    .toplevel_page_ninja-forms-3-0 #wpcontent * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing:    border-box;
        box-sizing:         border-box;
    }
    .nf-one-half,
    .nf-one-third {
        float: left;
    }
    .nf-one-half {
        width: 50%;
    }
    .nf-one-third {
        width: 33.33%;
    }
    .nf-first {
        clear: both;
        margin-left: 0;
    }
    .nf-full,
    .nf-one-half,
    .nf-one-third {
        margin-bottom: 15px;
        padding: 0 2%;
    }
    .nf-full:after,
    .nf-one-half:after,
    .nf-one-third:after {
        clear: both;
        content: "";
        display: block;
    }
    #nf-main {
        background: #fff;
        /*border: 3px solid red;*/
        float: left;
        padding: 40px;
        width: 50%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        overflow: scroll;
    }
    #nf-drawer {
        background: #EBEDEE;
        float: left;
        padding: 40px;
        width: 50%;
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        overflow: scroll;
    }
    #nf-drawer h2,
    #nf-drawer h3 {
        color: #666;
    }
    #nf-drawer h2 {
        float: left;
    }
    #nf-drawer h3 {
        clear: both;
    }
    #nf-drawer header {
        margin-bottom: 40px;
    }
    #nf-drawer header input[type=submit] {
        background: #28A0D6;
        border: 0;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        float: right;
        padding: 12px 30px;
    }
    #nf-drawer header input[type=search] {
        background: #f9f9f9;
        border: 0;
        padding: 12px 15px;
        content: "\f179";
    }
    #nf-drawer label {
        color: #999;
        padding-left: 3px;
    }
    #nf-drawer input[type=text] {
        background: #f9f9f9;
        border: 0;
        margin-top: 10px;
        padding: 12px 15px;
        width: 100%;
    }
    #nf-drawer select {
        background: #f9f9f9;
        border: 0;
        margin-top: 10px;
        height: 43px;
        padding: 0 15px;
        width: 100%;
        -webkit-appearance: none;
    }
    .nf-field-wrap {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
        padding: 10px 20px;
    }
    .nf-field-button {
        background: #666;
        border-radius: 4px;
        color: #f1f1f1;
        padding: 10px;
        text-align: center;
    }
    .nf-reservoir {
        border: 3px dashed #ccc;
        border-radius: 4px;
        min-height: 10px;
        padding-top: 3px;
    }
    .nf-reservoir:after {
        clear: both;
        content: "";
        display: block;
    }
    .nf-reservoir span {
        background: #666;
        border-radius: 4px;
        color: #f1f1f1;
        display: inline-block;
        float: left;
        margin: 0 3px 3px 3px;
        padding: 5px 10px;
    }
</style>

<div id="builder">

</div>


<script type="text/template" id="tmpl-nf-layout">

    <div id="nf-main">
        <!-- main content area. Where fields and actions are rendered. -->
    </div>

    <div id="nf-drawer">
        <!-- drawer area. This is where settings and add fields are rendered. -->
    </div>
</script>

<script type="text/template" id="tmpl-nf-edit-field">
    <!-- THIS IS THE CONTENT FOR EDITING FIELDS -->
    <header class="nf-full">
        <h2>Editing Field</h2>
        <span><input type="submit" class="save-field-settings" value="SAVE" /></span>
    </header>
    <div class="nf-one-half">
        <label>Label Name</label>
        <input type="text" />
    </div>
    <div class="nf-one-half">
        <label>Label Position</label>
        <select>
            <option>Above Field</option>
            <option>Below Field</option>
            <option>Left of Field</option>
            <option>Right of Field</option>
            <option>Hide Label</option>
        </select>
    </div>
    <div class="nf-full">
        <label>Class Name</label>
        <input type="text" />
    </div>
</script>

<script type="text/template" id="tmpl-nf-add-fields">
    <!-- THIS IS THE CONTENT FOR ADDING FIELDS -->
    <header class="nf-full">
        <input type="search" />
        <span><input type="submit" class="close-add-fields" value="DONE" /></span>
    </header>

    <div class="nf-reservoir">
        <span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span><span>Textbox</span>
    </div>

    <h3>Basic Fields</h3>

    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>


    <h3>Basic Fields</h3>

    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>

    <div class="nf-full">
        <h3>Basic Fields</h3>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Textarea</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Checkbox</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Dropdown</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Mult-Select</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Radio List</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Hidden Field</div>
    </div>
    <div class="nf-one-third">
        <div class="nf-field-button">Button</div>
    </div>
</script>

<script type="text/template" id="tmpl-nf-fields">
    <div class="nf-field-wrap">Field <a href="#" class="test">CLICK ME</a></div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
    <div class="nf-field-wrap">Field</div>
</script>