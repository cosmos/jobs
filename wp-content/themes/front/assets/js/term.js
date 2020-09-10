/**
 * masdocs.js
 *
 * Handles all scripts used by the theme
 */
/**
 * Setup anchors for documents
 */

anchors.add( '.page-template-template-terms-conditions .article__content > h3, .page-template-template-terms-conditions .article__content > h4, .list-group-block h3' );

generateTableOfContents( anchors.elements );

function generateTableOfContents( els ) {
    var toc = document.getElementById( 'table-of-contents' ),
        prevLevel = 0,
        root, curr;

    if ( toc === null ) return;

    if ( toc.classList.contains( 'd-none' ) ) {
        toc.classList.remove( 'd-none' );
        toc.classList.add( 'd-block' );
    }

    var closeLevel = function( e, levels ) {
        for (var i = 0; i < levels && e.parentElement && e.parentElement.parentElement; i++) {
            e = e.parentElement.parentElement;
        }
        return e;
    };

    for ( var i = 0; i < els.length; i++ ) {
        console.log(els[i]);
        var el = els[i],
            tag = el.tagName.toLowerCase(),
            curLevel = parseInt( tag.replace( /[^\d]/i, '' ), 10 ),
            contentElText = el.textContent,
            contentElHref = '#' + el.getAttribute('id'),
            li = getListItem( contentElHref, contentElText );


        if ( curLevel > prevLevel ) {
            if ( ! curr ) {
                root = document.createElement( 'UL' );
                root.appendChild( li ); 
                root.classList.add( 'js-scroll-nav' );
                root.classList.add( 'list-group' );
                root.classList.add( 'list-group-transparent' );
                root.classList.add( 'list-group-flush' );
                root.classList.add( 'list-group-borderless' );
                if ( toc.classList.contains( 'bg-primary' ) ) {
                    root.classList.add( 'list-group-white' );
                }
            } else {
                var ul = document.createElement( 'UL' );
                ul.appendChild( li );
                curr.appendChild( ul );
            }
        } else if ( curLevel === prevLevel ) {
            curr.parentElement.appendChild( li );
        } else if ( curLevel < prevLevel ) {
            var ancestor = closeLevel(curr, prevLevel - curLevel);
            ancestor.parentElement.appendChild(li);
        }
        curr = li;
        prevLevel = curLevel;
    }

    toc.appendChild( root );
}

function getListItem( href, text ) {
    var listItem   = document.createElement('LI'),
        linkItem = document.createElement('A'),
        textNode   = document.createTextNode(text);

    linkItem.href = href;
    linkItem.classList.add( 'list-group-item' );  
    linkItem.classList.add( 'list-group-item-action' ); 
    linkItem.classList.add( 'mb-2');
    linkItem.appendChild( textNode );
    listItem.appendChild( linkItem );
    return listItem;
}

( function( $ ) {
    'use strict';
    
    $('[data-toggle="tooltip"]').tooltip();
    
    // Smooth scroll
    // Select all links with hashes
    $('#table-of-contents a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click( function(event) {
        // On-page links
        if ( location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname ) {
            // Figure out element to scroll to
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            // Does a scroll target exist?
            if (target.length) {
                // Only prevent default if animation is actually gonna happen
                event.preventDefault();
                
                $('html, body').animate({ scrollTop: target.offset().top }, 1000, function() {
                    // Callback after animation
                    // Must change focus!
                    var $target = $(target);
                    $target.focus();
                    if ($target.is( ':focus' ) ) { // Checking if the target was focused
                        return false;
                    } else {
                        $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                        $target.focus(); // Set focus again
                    }
                });
            }
        }
    });
} )( jQuery );