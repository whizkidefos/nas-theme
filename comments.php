<?php if ( post_password_required() ) return; ?>

<div class="nas-comments" id="comments">

    <?php if ( have_comments() ): ?>
    <h3 class="nas-comments-title" style="font-family:var(--font-display);font-size:1.4rem;color:var(--nas-gold);margin-bottom:28px;padding-bottom:12px;border-bottom:var(--border-red)">
        <?php printf(
            esc_html( _nx( '%1$s Comment on "%2$s"', '%1$s Comments on "%2$s"', get_comments_number(), 'comments title', 'nas-theme' ) ),
            number_format_i18n( get_comments_number() ),
            get_the_title()
        ); ?>
    </h3>

    <ol class="nas-comment-list" style="list-style:none;padding:0;margin:0 0 40px">
        <?php wp_list_comments([
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 48,
            'callback'    => 'nas_comment_callback',
        ]); ?>
    </ol>

    <?php the_comments_pagination(['prev_text'=>'← Older','next_text'=>'Newer →']); ?>

    <?php endif; ?>

    <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ): ?>
    <p class="nas-comments-closed" style="color:var(--nas-gray);font-style:italic">Comments are closed.</p>
    <?php endif; ?>

    <?php
    comment_form([
        'title_reply'          => 'Leave a Comment',
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title" style="font-family:var(--font-display);font-size:1.4rem;color:var(--nas-gold);margin-bottom:24px">',
        'title_reply_after'    => '</h3>',
        'comment_notes_before' => '',
        'label_submit'         => 'Post Comment',
        'class_submit'         => 'btn btn-primary',
        'comment_field'        => '<div class="nas-form-group"><label for="comment">Comment *</label><textarea id="comment" name="comment" rows="6" required class="nas-comment-field" style="width:100%;padding:12px 14px;background:var(--nas-dark);border:1px solid rgba(255,221,0,0.1);color:var(--nas-white);font-family:var(--font-body);font-size:1rem;outline:none;resize:vertical"></textarea></div>',
        'fields' => [
            'author' => '<div class="nas-form-row" style="display:grid;grid-template-columns:1fr 1fr;gap:16px"><div class="nas-form-group"><label for="author">Name *</label><input id="author" name="author" type="text" required style="width:100%;padding:11px 14px;background:var(--nas-dark);border:1px solid rgba(255,221,0,0.1);color:var(--nas-white);font-family:var(--font-body);font-size:1rem;outline:none"></div>',
            'email'  => '<div class="nas-form-group"><label for="email">Email *</label><input id="email" name="email" type="email" required style="width:100%;padding:11px 14px;background:var(--nas-dark);border:1px solid rgba(255,221,0,0.1);color:var(--nas-white);font-family:var(--font-body);font-size:1rem;outline:none"></div></div>',
            'url'    => '',
            'cookies'=> '<p class="nas-form-group"><label style="display:flex;gap:8px;align-items:center;cursor:pointer;font-size:0.85rem;color:var(--nas-gray-light)"><input name="wp-comment-cookies-consent" type="checkbox" value="yes"> Save my name and email for next time.</label></p>',
        ],
    ]);
    ?>
</div>

<?php
function nas_comment_callback( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class('nas-comment-item',null,null,false); ?> style="background:var(--nas-dark-2);border:var(--border-red);padding:20px;margin-bottom:16px">
        <div style="display:flex;gap:14px;align-items:flex-start">
            <div style="flex-shrink:0;border-radius:50%;overflow:hidden;border:2px solid var(--nas-red)">
                <?php echo get_avatar($comment, 48); ?>
            </div>
            <div style="flex:1">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px">
                    <strong style="color:var(--nas-gold);font-family:var(--font-display)"><?php comment_author(); ?></strong>
                    <time style="font-family:var(--font-ui);font-size:10px;letter-spacing:0.1em;color:var(--nas-gray)"><?php comment_date(); ?></time>
                </div>
                <?php if ( '0' === $comment->comment_approved ): ?>
                <p style="color:var(--nas-gray);font-style:italic;font-size:0.875rem">Your comment is awaiting moderation.</p>
                <?php endif; ?>
                <div style="color:var(--nas-gray-light);line-height:1.7;font-size:0.95rem"><?php comment_text(); ?></div>
                <div style="margin-top:10px">
                    <?php comment_reply_link( array_merge( $args, ['depth'=>$depth,'max_depth'=>$args['max_depth'],'reply_text'=>'Reply'] ) ); ?>
                </div>
            </div>
        </div>
    </li>
    <?php
}
?>
