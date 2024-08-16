<nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item">
            <a class="page-link" href="?page=1" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>

        <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>"><?php echo ($page - 1) ?></a></li>
        <?php endif; ?>
        
            <li class="page-item active"><a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page ?></a></li>
        
        
        <?php if ($page < $totalPages): ?>
            <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>"><?php echo ($page + 1) ?></a></li>
        <?php endif; ?>
        
        <li class="page-item">
            <a class="page-link" href="?page=<?php echo $totalPages ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
</nav>