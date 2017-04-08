<html>
<head>
<title>My test editor - with tinyMCE and PHP</title>
<script language="javascript" type="text/javascript" src="tiny_mce.js"></script>
<!-- change src according to your needs -->
<script>
// Add a class to all paragraphs in the editor.
//tinyMCE.activeEditor.dom.addClass(tinyMCE.activeEditor.dom.select('p'), 'someclass');
// Gets the current editors selection as text
//tinyMCE.activeEditor.selection.getContent({format : 'text'});
// Creates a new editor instance
var ed = tinyMCE.Editor('textareaid', {
    some_setting : 1
});
// Select each item the user clicks on
ed.onClick.add(function(ed, e) {
    ed.selection.select(e.target);
});
ed.render();
</script>
</head>
<body>
<textarea id="textareaid"></textarea>
</body>
</html>