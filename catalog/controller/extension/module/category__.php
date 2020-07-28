<?php
class ControllerExtensionModuleCategory extends Controller {
	public $tree_level = 0;
	public $tree_html = '';
	//public $spacer = '&nbsp;&nbsp;&nbsp;-';
	public $spacer = '>';
	
	public function index() {

		$this->load->language('extension/module/category');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		/*$categories = $this->model_catalog_category->getCategories(0);

		
		foreach ($categories as $category) {
			$children_data = array();

			if ($category['category_id'] == $data['category_id']) {
				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach($children as $child) {
					$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

					$children_data[] = array(
						'category_id' => $child['category_id'],
						'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}
			}

			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'children'    => $children_data,
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
		}
		*/

		$categories = $this->model_catalog_category->getCategories(0);
		
		$this->tree_html = '';

		$this->tree_html .= '<ul class="list-group">';

		foreach ($categories as $category) {
			$this->tree_level = 0;
			$this->spacer = '';
			
			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);

			$record =  array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);

			$data['categories'][] = $record;

			 if ($category['category_id'] == $data['category_id']){
				$this->tree_html .= '<li class="list-group-item active"><a href="'.$record['href'].'" class="list-group-item-custom active">'.$record['name'].'</a></li>';
			 }else{
				$this->tree_html .= '<li class="list-group-item"><a href="'.$record['href'].'" class="list-group-item-custom ">'.$record['name'].'</a></li>';
			 } 

			 $record['children_data'] = $this->getChildren($category,$data); 

		}

		$this->tree_html .= '</ul>';

		$data['tree_html'] = $this->tree_html;

		return $this->load->view('extension/module/category', $data);
	}

	private function getChildren($category,$data){

		$this->tree_level++;

		$children_data = array();

		$children = $this->model_catalog_category->getCategories($category['category_id']);
		
		if(count($children) > 0){
			
			//$this->spacer = '&nbsp;&nbsp;&nbsp;'.$this->spacer;

			$this->tree_html .='<ul class="list-group">';

			foreach($children as $child) {			

				$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

				$record = array(
					'category_id' => $child['category_id'],
					'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])					
				);				

				if($child['category_id'] == $data['child_id']) {
					$this->tree_html .='<li class="list-group-item active"><a href="'.$record['href'].'" class="list-group-item-custom active">'.$this->spacer.$record['name'].'</a></li>'; 
				}else{
					$this->tree_html .='<li class="list-group-item"><a href="'.$record['href'].'" class="list-group-item-custom">'.$this->spacer.$record['name'].'</a></li>';
				}

				$record['children'] =  $this->getChildren($child,$data);
				
				$children_data[] = $record;
				
			}

			$this->tree_html .='</ul>';
		}

		return $children_data;
		
	}
}