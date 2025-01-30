<?php
function url_for($page_path): string
{
    $base_url = 'http://' . $_SERVER['HTTP_HOST'];
    $project_folder = 'shopping';
    $project_pos = strpos($_SERVER['REQUEST_URI'], $project_folder);
    $base_path = substr($_SERVER['REQUEST_URI'], 0, $project_pos + strlen($project_folder));
    return $base_url . $base_path . $page_path;
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?php echo url_for('/client/public/images/glasses-logo.png') ?>" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="<?php echo url_for('/client/index.php'); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url_for('/client/pages/price.php'); ?>">Price trend</a>
                </li>
            </ul>
        </div>
    </div>
</nav>