<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> หมวดหมู่</div>        
    <nav class="yamm megamenu-horizontal" role="navigation">
        <ul class="nav">
            <?php
            $sql = mysqli_query($con, "SELECT id, categoryName FROM category");
            while ($row = mysqli_fetch_array($sql)) {
            ?>
                <li class="dropdown menu-item">
                    <a href="category.php?cid=<?php echo $row['id']; ?>" class="dropdown-toggle">
                        <i class="icon fa fa-desktop fa-fw"></i> <?php echo $row['categoryName']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>
