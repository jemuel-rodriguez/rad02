primeShortcodeMeta={
	attributes:[
			{
				label:"Default 'Open' Title Text",
				id:"title_open",
				help:"The text of the title when the toggle is set to 'open'.",
				defaultValue:"Open Me"
			}, 
			{
				label:"Default 'Closed' Title Text",
				id:"title_closed",
				help:"The text of the title when the toggle is set to 'closed'.", 
				defaultValue:"Close Me"
			}, 
			{
				label:"Content",
				id:"content",
				help:"The content to be toggled.", 
				controlType:"textarea-control", 
				isRequired:true
			}, 
			{
				label:"Hide On Start",
				id:"hide",
				help:"Optionally hide the content on start.", 
				controlType:"select-control", 
				selectValues:['yes', 'no'],
				defaultValue: 'yes', 
				defaultText: 'yes (Default)'
			}, 
			{
				label:"Show Border",
				id:"border",
				help:"Optionally show a border around the toggle.", 
				controlType:"select-control", 
				selectValues:['yes', 'no'],
				defaultValue: 'yes', 
				defaultText: 'yes (Default)'
			},
		{
			label:"Toggle Style",
			id:"style",
			help:"Set an optional alternate style for the toggle.", 
			controlType:"select-control", 
			selectValues:['default', 'white'],
			defaultValue: 'default', 
			defaultText: 'default'
		}
			],
	defaultContent:"Content to be toggled.",
	shortcode:"toggle"
};
