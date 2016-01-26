// When the DOM has loaded, init the form link.
$(
	function(){
		// Get the add new upload link.
		var jAddNewUpload = $( "#add-file-upload" );
 
		// Hook up the click event.
		jAddNewUpload
			.attr( "href", "javascript:void( 0 )" )
			.click(
				function( objEvent ){
					AddNewUpload();
 
					// Prevent the default action.
					objEvent.preventDefault();
					return( false );
				}
				)
		;
 
	}
	)
 
 
// This adds a new file upload to the form.
function AddNewUpload(){
	// Get a reference to the upload container.
	var jFilesContainer = $( "#input" );
 
	// Get the file upload template.
	var jUploadTemplate = $( "#element-templates div.row" );
 
	// Duplicate the upload template. This will give us a copy
	// of the templated element, not attached to any DOM.
	var jUpload = jUploadTemplate.clone();
 
	// At this point, we have an exact copy. This gives us two
	// problems; on one hand, the values are not correct. On
	// the other hand, some browsers cannot dynamically rename
	// form inputs. To get around the FORM input name issue, we
	// have to strip out the inner HTML and dynamically generate
	// it with the new values.
	var strNewHTML = jUpload.html();
 
	// Now, we have the HTML as a string. Let's replace the
	// template values with the correct ones. To do this, we need
	// to see how many upload elements we have so far.
	var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
 
	// Set the proper ID.
	jUpload.attr( "id", ("in" + intNewFileCount) );
 
	// Replace the values.
	strNewHTML = strNewHTML
		.replace(
			new RegExp( "::FIELD2::", "i" ),
			intNewFileCount
			)
		.replace(
			new RegExp( "::FIELD3::", "i" ),
			("picase" + intNewFileCount)
			)
	;
 
	// Now that we have the new HTML, we can replace the
	// HTML of our new upload element.
	jUpload.html( strNewHTML );
	jFilesContainer.append( jUpload );
	
	var jFilesContainer = $( "#output" );
 
	// Get the file upload template.
	var jUploadTemplate = $( "#element-templates div.row" );
 
	// Duplicate the upload template. This will give us a copy
	// of the templated element, not attached to any DOM.
	var jUpload = jUploadTemplate.clone();
 
	// At this point, we have an exact copy. This gives us two
	// problems; on one hand, the values are not correct. On
	// the other hand, some browsers cannot dynamically rename
	// form inputs. To get around the FORM input name issue, we
	// have to strip out the inner HTML and dynamically generate
	// it with the new values.
	var strNewHTML = jUpload.html();
 
	// Now, we have the HTML as a string. Let's replace the
	// template values with the correct ones. To do this, we need
	// to see how many upload elements we have so far.
	var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
 
	// Set the proper ID.
	jUpload.attr( "id", ("out" + intNewFileCount) );
 
	// Replace the values.
	strNewHTML = strNewHTML
		.replace(
			new RegExp( "::FIELD2::", "i" ),
			intNewFileCount
			)
		.replace(
			new RegExp( "::FIELD3::", "i" ),
			("pocase" + intNewFileCount)
			)
	;
 
	// Now that we have the new HTML, we can replace the
	// HTML of our new upload element.
	jUpload.html( strNewHTML );
	
	// At this point, we have a totally intialized file upload
	// node. Let's attach it to the DOM.
	jFilesContainer.append( jUpload );
	
	var jFilesContainer = $( "#persentase" );
 
	// Get the file upload template.
	var jUploadTemplate = $( "#element-templates1 div.row" );
 
	// Duplicate the upload template. This will give us a copy
	// of the templated element, not attached to any DOM.
	var jUpload = jUploadTemplate.clone();
 
	// At this point, we have an exact copy. This gives us two
	// problems; on one hand, the values are not correct. On
	// the other hand, some browsers cannot dynamically rename
	// form inputs. To get around the FORM input name issue, we
	// have to strip out the inner HTML and dynamically generate
	// it with the new values.
	var strNewHTML = jUpload.html();
 
	// Now, we have the HTML as a string. Let's replace the
	// template values with the correct ones. To do this, we need
	// to see how many upload elements we have so far.
	var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
 
	// Set the proper ID.
	jUpload.attr( "id", ("persen" + intNewFileCount) );
 
	// Replace the values.
	strNewHTML = strNewHTML
		.replace(
			new RegExp( "::FIELD2:::", "i" ),
			""
			)
		.replace(
			new RegExp( "::FIELD3::", "i" ),
			("pros" + intNewFileCount)
			)
	;
 
	// Now that we have the new HTML, we can replace the
	// HTML of our new upload element.
	jUpload.html( strNewHTML );
	
	// At this point, we have a totally intialized file upload
	// node. Let's attach it to the DOM.
	jFilesContainer.append( jUpload );
	
	var jFilesContainer = $( "#delete" );
 
	// Get the file upload template.
	var jUploadTemplate = $( "#element-templates2 div.row" );
 
	// Duplicate the upload template. This will give us a copy
	// of the templated element, not attached to any DOM.
	var jUpload = jUploadTemplate.clone();
 
	// At this point, we have an exact copy. This gives us two
	// problems; on one hand, the values are not correct. On
	// the other hand, some browsers cannot dynamically rename
	// form inputs. To get around the FORM input name issue, we
	// have to strip out the inner HTML and dynamically generate
	// it with the new values.
	var strNewHTML = jUpload.html();
 
	// Now, we have the HTML as a string. Let's replace the
	// template values with the correct ones. To do this, we need
	// to see how many upload elements we have so far.
	var intNewFileCount = (jFilesContainer.find( "div.row" ).length + 1);
	var zonk = (jFilesContainer.find( "div.row" ).length);
	// Set the proper ID.
	jUpload.attr( "id", ("del" + intNewFileCount) );
 
	// Replace the values.
	strNewHTML = strNewHTML
		.replace(
			new RegExp( "::FIELD2::", "i" ),
			("deleteElement("+zonk+");")
			)
	;
 
	// Now that we have the new HTML, we can replace the
	// HTML of our new upload element.
	jUpload.html( strNewHTML );
	
	// At this point, we have a totally intialized file upload
	// node. Let's attach it to the DOM.
	jFilesContainer.append( jUpload );
}