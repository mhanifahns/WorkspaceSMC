<div style="padding: 20px;">
    <h2 style="color: #fff; margin-top: 0; font-weight: 500;">
        <i class="fas fa-search" style="color: var(--accent); margin-right: 10px;"></i>
        Global Search Results
    </h2>
    <p style="color: var(--text-muted); margin-bottom: 30px;">
        Found <?= count($results) ?> results for "<strong><?= htmlspecialchars($query) ?></strong>"
    </p>

    <?php if(empty($results)): ?>
        <div style="text-align: center; padding: 60px 20px; color: var(--text-muted);">
            <i class="fas fa-box-open" style="font-size: 64px; color: #24355a; margin-bottom: 20px; display: block;"></i>
            <h3 style="color: #fff; font-weight: 500; margin-bottom: 10px;">No Results Found</h3>
            <p>Try using different keywords or check your spelling.</p>
        </div>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px;">
            <?php foreach($results as $res): ?>
                <a href="<?= $res['link'] ?>" style="display: block; text-decoration: none; background-color: #1b2a47; border: 1px solid rgba(255,255,255,0.05); border-radius: 8px; padding: 20px; transition: all 0.3s;">
                    <div style="display: flex; align-items: flex-start; gap: 15px;">
                        <div style="width: 40px; height: 40px; border-radius: 8px; background-color: #152036; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: var(--accent); font-size: 18px;">
                            <i class="<?= $res['icon'] ?>"></i>
                        </div>
                        <div>
                            <div style="font-size: 11px; color: var(--accent); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 5px;">
                                <?= $res['type'] ?>
                            </div>
                            <h4 style="color: #fff; margin: 0 0 5px 0; font-weight: 500; font-size: 15px;">
                                <?= htmlspecialchars($res['title']) ?>
                            </h4>
                            <p style="color: var(--text-muted); font-size: 13px; margin: 0; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?= htmlspecialchars($res['desc']) ?>
                            </p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    a[href]:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        border-color: rgba(255,255,255,0.1) !important;
    }
</style>
