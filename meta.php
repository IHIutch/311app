<?php 

if (!strpos($_SERVER['REQUEST_URI'],'report_id')) {
    $meta = array(
        'title'    => 'Buffalo 311 (Beta)',
        'description'      => 'The data that the City of Buffalo collects in its day-to-day operations to make Buffalo a great place to live, work, and play are a valuable asset for all citizens. Data are the building blocks of information. Information applied is knowledge and knowledge is power.',
        'image' => 'http://$_SERVER[HTTP_HOST]/assets/images/meta.png',
        'url'    => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
    );
}


?>


<!-- HTML Meta Tags -->
<title><?php echo $meta['title']; ?></title>
<meta name="description" content="<?php echo $meta['description']; ?>">

<!-- Google / Search Engine Tags -->
<meta itemprop="name" content="<?php echo $meta['title']; ?>">
<meta itemprop="description" content="<?php echo $meta['description']; ?>">
<meta itemprop="image" content="<?php echo $meta['image']; ?>">

<!-- Facebook Meta Tags -->
<meta property="og:url" content="<?php echo $meta['url']; ?>">
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $meta['title']; ?>">
<meta property="og:description" content="<?php echo $meta['description']; ?>">
<meta property="og:image" content="<?php echo $meta['image']; ?>">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $meta['title']; ?>">
<meta name="twitter:description" content="<?php echo $meta['description']; ?>">
<meta name="twitter:image" content="<?php echo $meta['image']; ?>">