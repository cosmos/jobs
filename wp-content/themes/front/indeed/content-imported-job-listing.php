<li class="<?php echo esc_attr( $source ); ?>_job_listing job_listing" data-longitude="<?php echo esc_attr( $job->longitude ); ?>" data-latitude="<?php echo esc_attr( $job->latitude ); ?>">
    <div class="list card mw-100 mt-0 p-0">
        <div class="card-body p-4">
            <div class="media d-block d-sm-flex">
                <div class="u-avatar mb-3 mb-sm-0 mr-4 position-relative">
                    <img width="150" height="150" src="<?php echo esc_url( $job->logo ); ?>" class="img-fluid wp-post-image" alt="<?php echo esc_attr( $job->title ); ?>">
                </div>
                <div class="media-body">
                    <div class="media mb-2">
                        <div class="media-body mb-2">
                            <h1 class="h5 mb-1">
                                <a href="<?php echo esc_url( $job->url ); ?>" target="_blank" <?php echo $link_attributes; ?>>
                                    <?php echo esc_html( $job->title ); ?>
                                </a>
                            </h1>
                            <ul class="list-inline font-size-1 text-muted mb-3">
                                <li class="list-inline-item">
                                    <a class="link-muted" href="<?php echo esc_url( $job->url ); ?>">
                                        <span class="fas fa-building mr-1"></span>
                                        <?php echo esc_html( $job->company ); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="d-flex ml-auto">
                        </div>
                    </div>
                    <div class="d-md-flex align-items-md-center">
                        <div class="u-ver-divider u-ver-divider--none-md pr-4 mb-3 mb-md-0 mr-4">
                            <h2 class="small text-secondary mb-0"><?php esc_html__( 'Location', 'front' ); ?></h2>
                            <small class="text-secondary align-middle mr-1 fas fa-map-marker-alt"></small>
                            <span class="align-middle"><?php echo esc_html( $job->location ); ?></span>
                        </div>
                        <div class="u-ver-divider u-ver-divider--none-md pr-4 mb-3 mb-md-0 mr-4">
                            <h2 class="small text-secondary mb-0"><?php esc_html__( 'Posted', 'front' ); ?></h2>
                            <small class="text-secondary align-middle mr-1 fas fa-calendar-alt"></small>
                            <span class="align-middle">
                                <?php echo wp_kses_post( sprintf( __( '%s ago', 'front' ), human_time_diff( $job->timestamp, current_time( 'timestamp' ) ) ) ); ?>
                            </span>
                        </div>
                        <div class="ml-md-auto">
                            <span class="btn btn-xs btn-soft-danger btn-pill"><?php echo esc_html( $job->type ); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid card h-100 mw-100 mt-0 p-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-5">
            </div>
            <div class="text-center">
                <div class="u-lg-avatar mx-auto mb-3 position-relative">
                    <img width="150" height="150" src="<?php echo esc_url( $job->logo ); ?>" class="img-fluid wp-post-image" alt="<?php echo esc_attr( $job->title ); ?>">
                </div>
                <div class="mb-4">
                    <h1 class="h5 mb-1">
                        <a href="<?php echo esc_url( $job->url ); ?>" target="_blank" <?php echo $link_attributes; ?>>
                            <?php echo esc_html( $job->title ); ?>
                        </a>
                    </h1>
                    <ul class="list-inline font-size-1 text-muted mb-3">
                        <li class="list-inline-item">
                            <a class="link-muted" href="<?php echo esc_url( $job->url ); ?>">
                                <?php echo esc_html( $job->company ); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card-footer text-center py-4">
            <div class="row align-items-center">
                <div class="col-6 u-ver-divider">
                    <h2 class="small text-secondary mb-0"><?php esc_html__( 'Location', 'front' ); ?></h2>
                    <small class="text-secondary align-middle mr-1 fas fa-map-marker-alt"></small>
                    <span class="align-middle"><?php echo esc_html( $job->location ); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="list-grid card card-frame transition-3d-hover h-100 mw-100 mt-0 p-0">
        <a href="<?php echo esc_url( $job->url ); ?>" target="_blank" class="card-body p-3" <?php echo $link_attributes; ?>>
            <div class="media">
                <div class="u-avatar position-relative">
                    <img width="150" height="150" src="<?php echo esc_url( $job->logo ); ?>" class="img-fluid wp-post-image" alt="<?php echo esc_attr( $job->title ); ?>">
                </div>
                <div class="media-body px-4">
                    <h4 class="h6 text-dark mb-1"><?php echo esc_html( $job->title ); ?></h4>
                    <small class="d-block text-muted"></small>
                </div>
            </div>
        </a>
    </div>
    <a href="<?php echo esc_url( $job->url ); ?>" target="_blank" class="list-small card card-frame card-text-dark mw-100 mt-0 p-0"  <?php echo $link_attributes; ?>>
        <div class="card-body p-4">
            <div class="row justify-content-sm-between align-items-sm-center">
                <span class="col-sm-6 mb-2 mb-sm-0"><?php echo esc_html( $job->title ); ?></span>
                <span class="col-sm-6 text-primary text-sm-right">
                    <span class="fas fa-arrow-right small ml-2"></span>
                </span>
            </div>
        </div>
    </a>
    <div class="grid-small card card-frame text-center h-100 mw-100 mt-0 p-0">
        <div class="card-body p-6">
            <div class="u-avatar mx-auto mb-4 position-relative">
                <img width="150" height="150" src="<?php echo esc_url( $job->logo ); ?>" class="img-fluid rounded wp-post-image" alt="<?php echo esc_attr( $job->title ); ?>">
            </div>
            <div class="mb-4">
                <h4 class="h6 mb-1"><?php echo esc_html( $job->title ); ?></h4>
                <p></p>
            </div>
            <a class="btn btn-sm btn-soft-primary btn-wide" href="<?php echo esc_url( $job->url ); ?>" <?php echo $link_attributes; ?>>
                <?php echo esc_html__( "View Details", 'front' ); ?>
            </a>
        </div>
    </div>
</li>
