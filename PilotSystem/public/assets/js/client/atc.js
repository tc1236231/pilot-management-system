document.getElementById('freqList').ondblclick = function(){
	if(this.selectedIndex != -1)
	{
		MainWindowJSObject.switchFrequency(this.options[this.selectedIndex].value);	
	}
};

document.getElementById('clientList').ondblclick = function(){
	if(this.selectedIndex != -1)
	{
		MainWindowJSObject.kickClient(this.options[this.selectedIndex].value);	
	}
};