<?php
/**
 * @var $total float
 */
?>
<div id="partial-icon-symbols" class="icon-symbols" data-tg-refresh="partial-icon-symbols" data-tg-refresh-always="true">
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol id="info"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 11h1v7h-2v-5c-.552 0-1-.448-1-1s.448-1 1-1h1zm0 13C5.373 24 0 18.627 0 12S5.373 0 12 0s12 5.373 12 12-5.373 12-12 12zm0-2c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zM10.5 7.5c0-.828.666-1.5 1.5-1.5.828 0 1.5.666 1.5 1.5 0 .828-.666 1.5-1.5 1.5-.828 0-1.5-.666-1.5-1.5z"/></svg></symbol>
        <symbol id="caret-down"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><path d="M0 3h10L5 8" fill-rule="nonzero"/></svg></symbol>
        <symbol id="spinner-button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M20 10c0 5.523-4.477 10-10 10S0 15.523 0 10 4.477 0 10 0v2c-4.418 0-8 3.582-8 8s3.582 8 8 8 8-3.582 8-8h2z"/></svg></symbol>
        <symbol id="chevron-right"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><path d="M2 1l1-1 4 4 1 1-1 1-4 4-1-1 4-4"/></svg></symbol>
        <symbol id="down-arrow"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12"><path d="M10.817 7.624l-4.375 4.2c-.245.235-.64.235-.884 0l-4.375-4.2c-.244-.234-.244-.614 0-.848.245-.235.64-.235.884 0L5.375 9.95V.6c0-.332.28-.6.625-.6s.625.268.625.6v9.35l3.308-3.174c.122-.117.282-.176.442-.176.16 0 .32.06.442.176.244.234.244.614 0 .848"/></svg></symbol>
    </svg>
</div>
<aside role="complementary">
    <button class="order-summary-toggle order-summary-toggle--show" aria-expanded="false" aria-controls="order-summary">
        <span class="wrap">
            <span class="order-summary-toggle__inner">
                <span class="order-summary-toggle__icon-wrapper">
                    <svg width="20" height="19" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__icon">
                        <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z" />
                    </svg>
                </span>
                <span class="order-summary-toggle__text order-summary-toggle__text--show">
                    <span><?= Yii::t('frontend', 'Show order summary') ?></span>
                    <svg width="11" height="6" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__dropdown" fill="#000">
                        <path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z" />
                    </svg>
                </span>
                <span class="order-summary-toggle__text order-summary-toggle__text--hide">
                    <span><?= Yii::t('frontend', 'Hide order summary') ?></span>
                    <svg width="11" height="7" xmlns="http://www.w3.org/2000/svg" class="order-summary-toggle__dropdown" fill="#000">
                        <path d="M6.138.876L5.642.438l-.496.438L.504 4.972l.992 1.124L6.138 2l-.496.436 3.862 3.408.992-1.122L6.138.876z" />
                    </svg>
                </span>
                <dl class="order-summary-toggle__total-recap total-recap">
                    <dd><span class="order-summary__emphasis total-recap__final-price skeleton-while-loading"><?= Yii::$app->formatter->asCurrency($total) ?></span></dd>
                </dl>
            </span>
        </span>
    </button>
</aside>