<? pear::extending('default') ?>

<? pear::block('overstock') ?>
When manufacturers close out a product, or we need more warehouse room, you win! Our closeout and overstock items are designed to move fast thanks to deep discounts. But remember, these items may be in limited supply and are only available on a first-come, first-served basis. Also, manufacturer warranties may not apply. Items sell out quickly, so act fast!
<? pear::end() ?>

<? pear::block('overstock','prepend') ?>
Before Overstock [
<? pear::end() ?>

<? pear::block('overstock','append') ?>
] After Overstock
<? pear::end() ?>

<?= pear::extend() ?>