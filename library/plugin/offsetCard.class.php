<?php
class offsetCard extends Card
{
	public function add_tpl()
	{
        import('HtmlForm');
		$html = new HtmlForm('add',url('user:config:test',[],1));
        $radio = [['val'=>1,'title'=>'男','checked'=>'checked'],['val'=>2,'title'=>'女','checked'=>'']];
        $option = [['val'=>1,'name'=>'北京'],['val'=>2,'name'=>'上海']];
        $checkbox = [['val'=>1,'title'=>'北京','checked'=>'checked'],['val'=>2,'title'=>'天津','checked'=>'']];
        return $html->input(['name','卡名'],['name',['reg','pass']])->select(['city','城市'],$option)->checkbox(['clas','考点'],$checkbox)->textarea(['describe','商品描述'])->radio(['sex','性别'],$radio)->addFrom();
	}

    public function add()
    {
    	echo "in add";
    }

    public function receive()
    {
    	echo "in receive";
    }

    public function verification()
    {
    	echo "in verification";
    }
}


