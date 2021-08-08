<?php
/**
 * @var $urls
 */

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($urls as $url): ?>
        <url>
            <loc><?= htmlspecialchars(yii\helpers\Url::to($url['loc'], true)) ?></loc>
            <?php if(isset($url['lastmod'])): ?>
                <lastmod><?= is_string($url['lastmod']) ?
                        htmlspecialchars($url['lastmod']) : date(DATE_W3C, $url['lastmod']) ?></lastmod>
            <?php endif; ?>
            <changefreq><?= $url['changefreq']; ?></changefreq>
            <priority><?= $url['priority']; ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>