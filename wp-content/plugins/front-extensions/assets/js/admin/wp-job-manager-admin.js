jQuery(document).ready(function($) {
    // Data rows
    $( "input.job_manager_add_row" ).click(function(){
        $(this).closest('table').find('tbody').append( $(this).data('row') );
        return false;
    });

    // Sorting
    $('.wp-job-manager-repeated-rows tbody').sortable({
        items:'tr',
        cursor:'move',
        axis:'y',
        handle: 'td.sort-column',
        scrollSensitivity:40,
        forcePlaceholderSize: true,
        helper: 'clone',
        opacity: 0.65
    });
});