function obfuscator_toggleBlankReplace( blankCheckbox, ruleKey ) {

	var valueElement = document.getElementById( 'value-' + ruleKey );
	if ( blankCheckbox.checked == true ) {
		valueElement.value = '[Blank]';
		valueElement.disabled = true;
	} else {
		valueElement.value = '';
		valueElement.disabled = false;
	}

}

function obfuscator_toggleHiddenMessage( hiddenMessageId ) {

	var hiddenMessageElement = document.getElementById( hiddenMessageId );
	var hiddenMessageStatus = hiddenMessageElement.style.display;
	if ( hiddenMessageStatus == 'block' ) {
		hiddenMessageElement.style.display = 'none';
	} else {
		hiddenMessageElement.style.display = 'block';
	}

}