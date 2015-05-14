<div class="content">
    <h1 class="title"><?php echo Translator::get('pages.faq.freq_asked_que')?></h1>
<?php
if($empty){ ?>
	<h3 class="title"><?php echo Translator::get('pages.faq.no_question');?></h3>
<?php }

foreach($faqs as $k => $faq){ ?>
	<h3 class="title"><?php echo $faq->ask ?></h3>
	<p><?php echo $faq->answer; ?></p>
<?php } ?>

</div>