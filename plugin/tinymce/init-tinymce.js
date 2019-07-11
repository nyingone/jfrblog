tinymce.init({ 
    selector: "textarea.tinymce",

    /* theme of the editor */
    theme: "silver",
    /* skin: "lightgray", */

    /* width & height  */
    width: "100%",
    height: 300,

    statubar: true,

    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table contextmenu directionality emoticons template paste textcolor"
    ],

    /* toolbar */
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",

    /* style */
    style_formats:[
        {title: "Headers", items:[
            {title: "Header1", format: "h1"},
            {title: "Header2", format: "h2"},
            {title: "Header3", format: "h3"}
        ]},
        {title: "Inline", items: [
            {title: "Bold", icon: "bold", format: "bold"},
            {title: "Italic", icon: "italic", format: "italic"},
            {title: "Underlinec", icon: "underline", format: "underline"},
            {title: "Strikethrough", icon: "strikethrough", format: "strikethrough"},
            {title: "Superscript", icon: "superscript", format: "superscript"},
            {title: "Subcript", icon: "subscript", format: "subscript"},
            {title: "Code", icon: "code", format: "code"}
        ]},
        {title: "Blocks", items:[
            {title: "Paragraph", format: "p"},
            {title: "Blockquote", format: "blockquote"},
            {title: "Div", format: "div"},
            {title: "Pre", format: "pre"}
        ]},
        {title: "Alignment", items:[
            {title: "Left", icon: "alignleft", format: "alignleft"},
            {title: "Center", icon: "aligncenter", format: "aligncenter"},
            {title: "Right", icon: "alignright", format: "alignright"},
            {title: "Justify", icon: "alignjustify", format: "alignjustify"}
        ]}
    ]
});