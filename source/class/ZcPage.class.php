<?php
class page
{
	public $listRows;
	public $firstRows;
	public $totalRows;
	public $nowPage;
	public $config = array('header' => '条记录', 'prev' => '上一页', 'next' => '下一页', 'first' => '第一页', 'last' => '最后一页');

	public function __construct($totalRows, $listRows = '20')
	{
		$this->totalRows = $totalRows;
		$this->listRows = $listRows;
	}

	public function show($url = '', $setpages = 5, $rew = 0, $isAjax = false)
	{
		$curr_page = ((!(empty($_GET['page'])) ? max(intval($_GET['page']), 1) : 1));
		$multipage = '';

		if ($isAjax == false) {
			if ($this->listRows < $this->totalRows) {
				$page = $setpages + 1;
				$offset = ceil(($setpages / 2) - 1);
				$pages = ceil($this->totalRows / $this->listRows);
				$from = $curr_page - $offset;
				$to = $curr_page + $offset;
				$more = 0;

				if ($pages <= $page) {
					$from = 2;
					$to = $pages - 1;
				}
				 else {
					if ($from <= 1) {
						$to = $page - 1;
						$from = 2;
					}
					 else if ($pages <= $to) {
						$from = $pages - $page - 2;
						$to = $pages - 1;
					}


					$more = 1;
				}

				if (0 < $curr_page) {
					$multipage .= '<p>' . $this->totalRows . '条记录 ' . $curr_page . '/' . $pages . '页</p><li><a href="' . $this->pageurl($url, $curr_page - 1, $rew) . '" class="a1">' . $this->config['prev'] . '</a></li>';

					if ($curr_page == 1) {
						$multipage .= ' <li class="active"><a class="curPage">1</a></li>';
					}
					 else if ((6 < $curr_page) && $more) {
						$multipage .= ' <li><a href="' . $this->pageurl($url, 1, $rew) . '">1</a></li>..';
					}
					 else {
						$multipage .= ' <li><a href="' . $this->pageurl($url, 1, $rew) . '">1</a></li>';
					}
				}


				$i = $from;

				while ($i <= $to) {
					if ($i != $curr_page) {
						$multipage .= ' <li><a href="' . $this->pageurl($url, $i, $rew) . '">' . $i . '</a></li>';
					}
					 else {
						$multipage .= ' <li class="active"><a  class="curPage">' . $i . '</a></li>';
					}

					++$i;
				}

				if ($curr_page < $pages) {
					if (($curr_page < ($pages - 5)) && $more) {
						$multipage .= ' ..<li><a href="' . $this->pageurl($url, $pages, $rew) . '">' . $pages . '</a></li> <li><a href="' . $this->pageurl($url, $curr_page + 1, $rew) . '" class="a1">' . $this->config['next'] . '</a></li>';
					}
					 else {
						$multipage .= ' <li><a href="' . $this->pageurl($url, $pages, $rew) . '">' . $pages . '</a></li> <li><a href="' . $this->pageurl($url, $curr_page + 1, $rew) . '" class="a1">' . $this->config['next'] . '</a></li>';
					}
				}
				 else if ($curr_page == $pages) {
					$multipage .= ' <li class="active"><a  class="curPage">' . $pages . '</a></li> <li><a href="' . $this->pageurl($url, $curr_page, $rew) . '" class="a1">' . $this->config['next'] . '</a></li>';
				}
				 else {
					$multipage .= ' <li><a href="' . $this->pageurl($url, $pages, $rew) . '">' . $pages . '</a></li> <li><a href="' . $this->pageurl($url, $curr_page + 1, $rew) . '" class="a1">' . $this->config['next'] . '</a><li>';
				}
			}

		}
		 else if ($this->listRows < $this->totalRows) {
			$page = $setpages + 1;
			$offset = ceil(($setpages / 2) - 1);
			$pages = ceil($this->totalRows / $this->listRows);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;

			if ($pages <= $page) {
				$from = 2;
				$to = $pages - 1;
			}
			 else {
				if ($from <= 1) {
					$to = $page - 1;
					$from = 2;
				}
				 else if ($pages <= $to) {
					$from = $pages - $page - 2;
					$to = $pages - 1;
				}


				$more = 1;
			}

			if (0 < $curr_page) {
				$multipage .= '<a href="javascript:;" class="prev" page="' . ($curr_page - 1) . '">' . $this->config['prev'] . '</a>';

				if ($curr_page == 1) {
					$multipage .= ' <a class="current">1</a>';
				}
				 else if ((6 < $curr_page) && $more) {
					$multipage .= ' <a href="javascript:;" page="1">1</a><span>..</span>';
				}
				 else {
					$multipage .= ' <a href="javascript:;" page="1">1</a>';
				}
			}


			$i = $from;

			while ($i <= $to) {
				if ($i != $curr_page) {
					$multipage .= ' <a href="javascript:;" page="' . $i . '">' . $i . '</a>';
				}
				 else {
					$multipage .= ' <a  class="current">' . $i . '</a>';
				}

				++$i;
			}

			if ($curr_page < $pages) {
				if (($curr_page < ($pages - 5)) && $more) {
					$multipage .= '<span>..</span><a href="javascript:;" page="' . $page . '">' . $pages . '</a><a href="javascript:;" page="' . ($curr_page + 1) . '" class="next">' . $this->config['next'] . '</a>';
				}
				 else {
					$multipage .= ' <a href="javascript:;"  page="' . $pages . '">' . $pages . '</a> <a href="javascript:;" page="' . ($curr_page + 1) . '" class="next">' . $this->config['next'] . '</a>';
				}
			}
			 else if ($curr_page == $pages) {
				$multipage .= ' <a  class="current">' . $pages . '</a><a href="javascript:;" page="' . $curr_page . '" class="next">' . $this->config['next'] . '</a>';
			}
			 else {
				$multipage .= ' <a href="javascript:;" page="' . $pages . '">' . $pages . '</a> <a href="javascript:;" page="' . ($curr_page + 1) . '" class="next">' . $this->config['next'] . '</a>';
			}
		}


		$this->firstRows = $this->listRows * ($curr_page - 1);
		return $multipage;
	}

	public function pageurl($url = '', $page = '', $rew = '')
	{
		if (1 <= $rew) {
			$page = (($page < 1 ? 1 : $page));
			$url = '/' . $_GET['a'] . '/' . $_GET['cat_key'] . '/' . $page;
		}
		 else {
			$page = (($page < 1 ? 1 : $page));
			$url = $url . 'page=' . $page;
		}

		return $url;
	}
}


?>