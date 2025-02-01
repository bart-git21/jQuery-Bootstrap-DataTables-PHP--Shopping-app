<?php
function getRootPath():string
{
    $filePath = parse_url(__FILE__)["path"];
    $rootDirPos = strrpos($filePath, "client");
    $directoryPath = substr($filePath, 0, $rootDirPos);
    return str_replace("\\", "/", $directoryPath);
}
$path = getRootPath(); 
define("ROOT_PATH", "http:/" .getRootPath());
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?php echo ROOT_PATH . 'client/public/images/glasses-logo.png'; ?>" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                        href="<?php echo ROOT_PATH . 'client/index.php'; ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="priceNavBtn" href="<?php echo ROOT_PATH . 'client/pages/price.php'; ?>">Price trend</a>
                </li>
            </ul>
        </div>
    </div>
</nav>