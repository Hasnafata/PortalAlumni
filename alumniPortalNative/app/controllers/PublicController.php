<?php
require_once __DIR__.'/../helpers/utils.php';
require_once __DIR__.'/../models/AlumniModel.php';
function public_home(){ view('public/home.php'); }
function public_search(){
    $q = trim(input('q',''));
    $page = max(1,(int)input('page',1));
    $list = AlumniModel::getPublicList($q,$page,12);
    $total = AlumniModel::countPublic($q);
    view('public/search.php',[ 'q'=>$q,'list'=>$list,'total'=>$total,'page'=>$page,'per'=>12 ]);
}
function public_alumni_detail(){
  $id=(int)input('id');
  $d=AlumniModel::findPublicById($id);
  if(!$d){ http_response_code(404); echo '<div style="padding:2rem;font-family:ui-sans-serif">Data tidak ditemukan.</div>'; return; }
  view('public/detail.php',[ 'd'=>$d ]);
}
