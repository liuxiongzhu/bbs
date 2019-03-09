<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('collection_index');
0
|| checktplrefresh('./template/default/forum/collection_index.htm', './template/default/forum/collection_nav.htm', 1551064140, '1', './data/template/1_1_forum_collection_index.tpl.php', './template/default', 'forum/collection_index')
|| checktplrefresh('./template/default/forum/collection_index.htm', './template/default/forum/collection_list.htm', 1551064140, '1', './data/template/1_1_forum_collection_index.tpl.php', './template/default', 'forum/collection_index')
;?><?php include template('common/header'); ?><div id="pt" class="bm cl">
<div class="z">
<a href="./" class="nvhm" title="首页"><?php echo $_G['setting']['bbname'];?></a> <em>&rsaquo;</em>
<a href="forum.php?mod=collection">淘帖</a> <em>&rsaquo;</em>
<a href="forum.php?mod=collection">推荐专辑</a>
</div>
</div>

<div id="ct" class=" wp cl">
<div class="bm">
<div class="tb tb_h cl"><ul>
<?php if(helper_access::check_module('collection')) { ?>
<li class="y o"><a href="forum.php?mod=collection&amp;action=edit">创建淘专辑</a></li>
<?php } ?>
<li<?php if(!$op && !$tid) { ?> class="a"<?php } ?>><a href="forum.php?mod=collection">推荐专辑</a></li>
<li<?php if($op == 'all') { ?> class="a"<?php } ?>><a href="forum.php?mod=collection&amp;op=all">所有专辑</a></li>
<li<?php if($op == 'my') { ?> class="a"<?php } ?>><a href="forum.php?mod=collection&amp;op=my">我的专辑</a></li>
<?php if(!$op && $tid) { ?><li class="a"><a href="forum.php?mod=collection&amp;tid=<?php echo $tid;?>">相关专辑</a></li><?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['collection_nav_extra'])) echo $_G['setting']['pluginhooks']['collection_nav_extra'];?>
</ul></div>
<div class="bm_c">
<?php if(!empty($_G['setting']['pluginhooks']['collection_index_top'])) echo $_G['setting']['pluginhooks']['collection_index_top'];?><?php if(count($collectiondata) > 0) { ?>
<div class="clct_list cl"><?php if(is_array($collectiondata)) foreach($collectiondata as $collectionvalues) { ?><div class="xld xlda cl">
<dl>
<dd class="m hm">
<a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $collectionvalues['ctid'];?><?php if($op) { ?>&amp;fromop=<?php echo $op;?><?php } if($tid) { ?>&amp;fromtid=<?php echo $tid;?><?php } ?>">
<strong class="xi2" <?php if($collectionvalues['displaynum'] > 999999) { ?>style="font-size: 10px;"<?php } ?>><?php echo $collectionvalues['displaynum'];?></strong>
<span style="color: #FFF"><?php if($orderby=='commentnum') { ?>评论<?php } elseif($orderby=='follownum') { ?>订阅<?php } else { ?>主题<?php } ?></span>
</a>
</dd>
<dt class="xw1">
<?php if($op == 'my') { if($collectionvalues['uid'] == $_G['uid']) { ?>
<span class="ctag ctag0">我创建的</span>
<?php } elseif(in_array($collectionvalues['ctid'], $twctid)) { ?>
<span class="ctag ctag1">我参与的</span>
<?php } else { ?>
<span class="ctag ctag2">我订阅的</span>
<?php } } ?>
<div>
<a href="forum.php?mod=collection&amp;action=view&amp;ctid=<?php echo $collectionvalues['ctid'];?><?php if($op) { ?>&amp;fromop=<?php echo $op;?><?php } if($tid) { ?>&amp;fromtid=<?php echo $tid;?><?php } ?>" class="xi2" <?php if($collectionvalues['updated'] && $op == 'my') { ?>style='color:red;'<?php } ?>><?php echo $collectionvalues['name'];?></a>
<?php if($collectionvalues['arraykeyword']) { ?>
<span class="ctag_keyword"><?php $keycount=0;?><?php if(is_array($collectionvalues['arraykeyword'])) foreach($collectionvalues['arraykeyword'] as $unique_keyword) { if($keycount) { ?>,&nbsp;<?php } ?><a href="search.php?mod=<?php if($_G['setting']['search']['collection']['status']) { ?>collection<?php } else { ?>forum<?php } ?>&amp;srchtxt=<?php echo rawurlencode($unique_keyword); ?>&amp;formhash=<?php echo FORMHASH;?>&amp;searchsubmit=true&amp;source=collectionsearch" target="_blank" class="xi2"><?php echo $unique_keyword;?></a><?php $keycount++;?><?php } ?>
</span>
<?php } ?>
</div>
</dt>
<dd>
<p><?php echo $collectionvalues['shortdesc'];?></p>
<p>
<?php if($orderby=='commentnum') { ?>
订阅 <?php echo $collectionvalues['follownum'];?>, 主题 <?php echo $collectionvalues['threadnum'];?>
<?php } elseif($orderby=='follownum') { ?>
主题 <?php echo $collectionvalues['threadnum'];?>, 评论 <?php echo $collectionvalues['commentnum'];?>
<?php } else { ?>
订阅 <?php echo $collectionvalues['follownum'];?>, 评论 <?php echo $collectionvalues['commentnum'];?>
<?php } ?>
</p>
<p class="xg1"><a href="home.php?mod=space&amp;uid=<?php echo $collectionvalues['uid'];?>"><?php echo $collectionvalues['username'];?></a> 创建, 最后更新 <?php echo $collectionvalues['lastupdate'];?></p>
<p>
<?php if($collectionvalues['lastpost']) { ?>
最新主题 <a href="forum.php?mod=viewthread&amp;tid=<?php echo $collectionvalues['lastpost'];?>" class="xi2"><?php echo $collectionvalues['lastsubject'];?></a>
<?php } ?>
</p>
</dd>
</dl>
</div>
<?php } ?>
</div>
<?php } else { ?>
<div class="emp">还没有淘专辑，快来<a href="forum.php?mod=collection&amp;action=edit">创建</a>吧</div>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['collection_index_bottom'])) echo $_G['setting']['pluginhooks']['collection_index_bottom'];?>
</div>
</div>
<?php echo $multipage;?>
<br /><br />
</div><?php include template('common/footer'); ?>