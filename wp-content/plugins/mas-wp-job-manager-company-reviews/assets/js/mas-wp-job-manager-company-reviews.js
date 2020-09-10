jQuery( document ).ready( function( $ ) {

    $( '.choose-rating' ).on( 'click', '.star', function( event ) {

        // Remove all current stars
        $( this ).nextAll( '.star' ).removeClass( 'active' );
        $( this ).prevAll( '.star' ).removeClass( 'active' );

        $( this ).addClass( 'active' );
        
        // Set rating at the hidden input
        $( this ).parent().find( 'input' ).attr( 'value', $( this ).attr( 'data-star-rating' ) );
    });

});