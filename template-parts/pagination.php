<?php if (paginate_links()) : //ページが1ページ以上あれば以下を表示
?>
    <!-- pagenation -->
    <div class="pagenation">
        <?php
        echo paginate_links(
            array(
                'end_size' => 1,//ページ番号のリストの両端にいくつ数字を表示するか
                'mid_size' => 1,//現在のページの両端にいくつ数字を表示するか
                'prev_next' => true,//リストの中に前へ次へのリンクを含めるか
                'prev_text' => '<i class="fas fa-angle-left"></i>',//prev_nextがtrueの時、前ページのリンクとして表示する文言
                'next_text' => '<i class="fas fa-angle-right"></i>',//prev_nextがtrueの時、次ページのリンクとして表示する文言
            )
        );
        ?>
    </div><!-- /pagenation -->
<?php endif; ?>