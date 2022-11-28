<?php

/**
 * テーマのセットアップ
 * 参考：https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_theme_support#HTML5
 **/
function my_setup()
{
  add_theme_support('post-thumbnails'); // アイキャッチ画像を有効化
  add_theme_support('automatic-feed-links'); // 投稿とコメントのRSSフィードのリンクを有効化
  add_theme_support('title-tag'); // タイトルタグ自動生成
  add_theme_support(
    'html5',
    array( //HTML5でマークアップ
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    )
  );
}

add_action('after_setup_theme', 'my_setup');
// セットアップの書き方の型
// function custom_theme_setup() {
// add_theme_support( $feature, $arguments );
// }
// add_action( 'after_setup_theme', 'custom_theme_setup' );



/**
 * CSSとJavaScriptの読み込み
 */
function my_script_init()
{
  wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.2/css/all.css', array(), '5.8.2', 'all');
  wp_enqueue_style('my_style', get_template_directory_uri().'/css/style.css', array(), filemtime(get_theme_file_path('/css/style.css')), 'all'); //元のテーマスタイルの読み込みとスタイルキャッシュ
  wp_enqueue_style('highlight_library_css', get_template_directory_uri().'/css/monokai-sublime.min.css', array(), filemtime(get_theme_file_path('/css/monokai-sublime.min.css')), 'all'); //後から追加したスタイルの読み込みとスタイルキャッシュ
  wp_enqueue_style('my_add_style', get_template_directory_uri().'/css/add.css', array(), filemtime(get_theme_file_path('/css/add.css')), 'all'); //後から追加したスタイルの読み込みとスタイルキャッシュ
  wp_enqueue_script('highlight_library_js', get_template_directory_uri().'/js/highlight.min.js', array('jquery'), filemtime(get_theme_file_path('/js/highlight.min.js')), true);
  wp_enqueue_script('my_script', get_template_directory_uri().'/js/script.js', array('jquery'), filemtime(get_theme_file_path('/js/script.js')), true);
  if (is_home() || is_single() || is_page() || is_category() || is_tag()) {
    wp_enqueue_script('sns', get_template_directory_uri() . '/js/sns.js', array('jquery'), '1.0.0', true);
  }
}
add_action('wp_enqueue_scripts', 'my_script_init');

/**
 * 抜粋の続きの書き方
 *
 * 
 */
function new_excerpt_more($more) {
  $more = '・・・・・・・・つづき';
  return "$more";  //変更する文字を返す
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * メニューの登録
 *
 * 参考：https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_nav_menus
 */
function my_menu_init()
{
  register_nav_menus(
    array(
      'global' => 'ヘッダーメニュー',
      'drawer' => 'ドロワーメニュー',
      'footer' => 'フッターメニュー'
    )
  );
}
add_action('init', 'my_menu_init');


/**
 * アーカイブタイトル書き換え
 *
 * @param string $title 書き換え前のタイトル.
 * @return string $title 書き換え後のタイトル.
 */

function my_archive_title($title)
{
  if (is_category()) { // カテゴリーアーカイブの場合
    $title = single_cat_title('', false);
  } elseif (is_tag()) { //タグアーカイブの場合 
    $title = single_tag_title('', false);
  } elseif (is_post_type_archive()) { // 投稿タイプのアーカイブの場合
    $title = post_type_archive_title('', false);
  } elseif (is_tax()) { // タームアーカイブの場合
    $title = single_term_title('', false);
  } elseif (is_author()) { // 作者アーカイブの場合
    $title = get_the_author();
  } elseif (is_date()) { // 日付アーカイブの場合
    $title = '';
    if (get_query_var('year')) {
      $title .= get_query_var('year') . '年';
    }
    if (get_query_var('monthnum')) {
      $title .= get_query_var('monthnum') . '月';
    }
    if (get_query_var('day')) {
      $title .= get_query_var('day') . '日';
    }
  }
  return $title;
};
add_filter('get_the_archive_title', 'my_archive_title');

function add_title($title)
{
  if (is_category()) {
    $title = 'CATEGORY';
  } elseif (is_tag()) {
    $title = 'TAG';
  } elseif (is_date()) {
    $title = 'DATE';
  }
  echo '<p style="color:red; font-weight:bold;">' . $title . '</p>';
}
add_action('my_title_color_hook', 'add_title');




/**
 * カテゴリーを1つだけ表示
 *
 * @param boolean $anchor aタグで出力するかどうか.
 * @param integer $id 投稿id.
 * @return void
 */

//カテゴリー1つ目の名前を表示するという処理を、$anchor=trueとして渡せばリンク付き、falseとしてわたせば、リンクなしで出力するという処理
function my_the_post_category($anchor = true, $id = 0)
{
  global $post; //$postをグローバルとして宣言
  if ($id === 0) { //引数がなければ投稿IDを指定
    $id = $post->ID; //現在の投稿のIDを与える
  }
  $this_categories = get_the_category($id);
  if ($this_categories[0]) {
    if ($anchor) { //$anchorがtrueならリンク付きで出力
      echo '<a href="' . esc_url(get_category_link($this_categories[0]->term_id)) . '">' . esc_html($this_categories[0]->cat_name) . '</a>';
    } else { //$anchorがfalseで指定された場合はカテゴリー名のみ出力
      echo esc_html($this_categories[0]->cat_name);
    }
  }
}

/**
 * タグ取得
 *
 * @param integer $id 投稿id.
 * @return void
 */
function my_get_post_tags($id = 0)
{
  global $post;
  //引数が渡されなければ投稿IDを見るように設定
  if ($id === 0) {
    $id = $post->ID;
  }
  $tags = get_the_tags($id);
  if ($tags) {
    foreach ($tags as $tag) {
      echo '<div class="entry-tag-item"><a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a></div><!-- /entry-tag-item -->';
    }
  }
}

/**
* ウィジェットの登録
*
* @codex http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/register_sidebar
*/

function my_widget_init(){
  register_sidebar(array(
    'name' =>'サイドバー', //表示するエリア名
    'id' =>'sidebar',//id
    'before_widget' =>'<div id="%1$s" class="widget %2$s">', //ウィジェットの直前に出力する HTML テキスト
    'after_widget' => '</div>', //ウィジェットの直後に出力する HTML テキスト
    'before_title' => '<div class="widget-title">', //タイトルの直前に出力する HTML テキスト
    'after_title' => '</div>', //タイトルの直後に出力する HTML テキスト
  ));
}
add_action('widgets_init','my_widget_init');


/**
* カスタムフィールドを使ってアクセス数を取得する（特定記事のアクセス数確認用）
*
* @param integer $id 投稿id.
* @return void
*/
//アクセス数を取得

function get_post_views($id = 0){
  global $post;
  //引数が渡されなければ投稿IDを見るように設定
  if($id === 0){
    $id = $post->ID;
  }
  $count_key ='view_counter';
  $count = get_post_meta($id, $count_key, true);//キーの値を取得して$postに格納

  if($count === ''){//値がなければ一回削除して0に更新
    delete_post_meta($id, $count_key);
    add_post_meta($id, $count_key, '0');
  }
  return $count;
}

/**
* アクセスカウンター
*
* @return void
*/
function set_post_views(){
  global $post;
  $count = 0;
  $count_key = 'view_counter';

  if(!is_single()){//シングルページでなければ処理は終了。閲覧としてカウントしない
    return;
  }

  if($post){
    $id = $post ->ID; 
    $count =get_post_meta($id, $count_key, true);
  }

  if($count ===''){//取得した$countに何もデータがない状態であればそのデータを削除して、1に更新する
    delete_post_meta($id, $count_key);
    add_post_meta($id, $count_key,'1');
  }elseif($count >0){//$countが0より大きければ、管理者意外の閲覧を1足して更新
    if(!is_user_logged_in()){
      $count++;
      update_post_meta($id, $count_key, $count);
    }
  }
  //$countが0の場合は何も処理しない。
}
add_action('template_redirect','set_post_views',10);

/**
* 検索結果から固定ページを除外する
// @param [Type] [name] [<description>] →型、要素内での変数名、その説明  このタグでは引数のメタ情報を明示する場合に使用します。

* @param string $search SQLのWHERE句の検索条件文

* @param object $wp_query WP_Queryのオブジェクト

// @return [Type] [<description>]  →返り値の型と説明です。
* @return string $search 条件追加後の検索条件文
*/
function my_posts_search($search, $wp_query){
    //検索結果ページ・メインクエリ・管理画面以外の3つの条件が揃った場合
  if($wp_query->is_search() && $wp_query->is_main_query() && !is_admin() ){
    // 検索結果を投稿タイプに絞る
    $search .= " AND post_type ='post' ";
    return $search; 
  }
  return $search;
}
//posts_searchフィルター→WP_Query の WHERE 節で使用される検索 SQL に適用される。
add_filter('posts_search','my_posts_search',10,2);

/**
* ボタンのショートコード
*
* @param array $atts ショートコードの引数.
* @param string $content ショートコードのコンテンツ.
* @return string ボタンのHTMLタグ.
* @codex https://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_shortcode
*/
function my_shortcode( $atts, $content = '' ) {
  return '<div class="entry-btn"><a class="btn" href="' . $atts['link'] . '">' . $content . '</a></div><!-- /entry-btn -->';
  }
  add_shortcode( 'btn', 'my_shortcode' );


function add_my_contents_after_post($content){
  if(is_single() && get_post_type() === 'post'){
    $custom_content = do_shortcode('[btn link="http://localhost:8888/dev/contact/"]お問い合わせはこちら[/btn]');
    $content .= $custom_content ;
    return $content;
  }else{
    return $content;
  }
}
add_filter('the_content','add_my_contents_after_post' );



//シンタックスhighlight導入のためのショートコード
function highlight_shortcode($class, $content = '')
{
    if ($class['class'] == 'html') {
      //HTMLの場合は特殊文字をエスケープ
      $content = esc_html($content);
    }
  return '<pre><code class = "' . $class['class'] . '">' . $content  . '</code></pre>';
}
add_shortcode('highlight', 'highlight_shortcode');

