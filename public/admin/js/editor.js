ClassicEditor
    .create( document.querySelector( '#article_text' ), {
        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'Link', 'Heading' ]
    } )
    .catch( error => {
        console.log( error );
    } );
ClassicEditor
    .create( document.querySelector( '#edit_text' ), {
        toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'Link', 'Heading' ]
    } )
    .catch( error => {
        console.log( error );
    } );