window.embeddable_job_widget = function() {
	var embeddable_job_widget_page = 1;
	var embeddable_job_widget_script;
	return {
		get_jobs : function( page ) {
			var head     = document.getElementsByTagName( "head" )[0];
			embeddable_job_widget_script       = document.createElement( "script" );
			embeddable_job_widget_script.async = true;
			embeddable_job_widget_script.src   = embeddable_job_widget_options.script_url
				+ '&keywords=' + encodeURIComponent( embeddable_job_widget_options.keywords )
				+ '&location=' + encodeURIComponent( embeddable_job_widget_options.location )
				+ '&categories=' + encodeURIComponent( embeddable_job_widget_options.categories )
				+ '&job_type=' + encodeURIComponent( embeddable_job_widget_options.job_types )
				+ '&per_page=' + encodeURIComponent( embeddable_job_widget_options.per_page )
				+ '&pagination=' + encodeURIComponent( embeddable_job_widget_options.pagination )
				+ '&page=' + encodeURIComponent( page );
			head.appendChild( embeddable_job_widget_script );
			return false
		},
		show_jobs : function( target_id, content ) {
			var target = document.getElementById( target_id );
			if ( target ) {
				target.innerHTML = this.decode_html( content );
			}
		},
		decode_html : function( html ) {
   			var txt = document.createElement( "textarea" );
    		txt.innerHTML = html;
    		return txt.value;
		},
		prev_page : function() {
			embeddable_job_widget_script.parentNode.removeChild( embeddable_job_widget_script );
			embeddable_job_widget_page = embeddable_job_widget_page - 1;

			if ( embeddable_job_widget_page < 1 ) {
				embeddable_job_widget_page = 1;
			}

			this.get_jobs( embeddable_job_widget_page )
		},
		next_page : function() {
			embeddable_job_widget_script.parentNode.removeChild( embeddable_job_widget_script );
			embeddable_job_widget_page = embeddable_job_widget_page + 1;
			this.get_jobs( embeddable_job_widget_page )
		}
	}
}();

window.embeddable_job_widget.get_jobs( 1 );