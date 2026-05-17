<form role="search" method="get" class="nas-search-form" action="<?php echo home_url('/'); ?>">
    <div class="nas-search-wrap">
        <input type="search" class="nas-search-input"
               placeholder="<?php echo esc_attr_x('Search NAS…','placeholder','nas-theme'); ?>"
               value="<?php echo get_search_query(); ?>"
               name="s" required>
        <button type="submit" class="nas-search-btn" aria-label="Search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
        </button>
    </div>
</form>
<style>
.nas-search-form{max-width:600px;margin:0 auto}
.nas-search-wrap{display:flex}
.nas-search-input{flex:1;padding:13px 18px;background:var(--nas-dark-2);border:1px solid rgba(255,221,0,0.15);border-right:none;color:var(--nas-white);font-family:var(--font-body);font-size:1rem;outline:none}
.nas-search-input:focus{border-color:rgba(255,221,0,0.3)}
.nas-search-input::placeholder{color:var(--nas-gray)}
.nas-search-btn{padding:0 20px;background:var(--nas-red);border:1px solid var(--nas-red);color:var(--nas-gold);cursor:pointer;transition:background var(--transition-fast)}
.nas-search-btn:hover{background:var(--nas-red-light)}
</style>
