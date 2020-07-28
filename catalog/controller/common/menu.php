<?php
class ControllerCommonMenu extends Controller {
	public function index() {
		$this->load->language('common/menu');

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}


		$categories = $this->model_catalog_category->getCategories(0);
		
		$this->tree_html = '';
	
		foreach ($categories as $category) {
			$this->tree_level = 0;
			$this->spacer = '>';
			
			$filter_data = array(
				'filter_category_id'  => $category['category_id'],
				'filter_sub_category' => true
			);
	
			$record =  array(
				'category_id' => $category['category_id'],
				'name'        => $category['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'href'        => $this->url->link('product/category', 'path=' . $category['category_id'])
			);
	
			$data['repair'][] = $record;
			$record['children_data'] = $this->getChildren($category,$data); 
	
		}
	
		$data['buy_href'] = $this->url->link('product/category/all');
		$data['sell_href'] = $this->url->link('service/sell');
		$data['repair_href'] = $this->url->link('service/repair');

		return $this->load->view('common/menu', $data);
	}
	

private function getChildren($category,$data){

	$this->tree_level++;

	$children_data = array();

	$children = $this->model_catalog_category->getCategories($category['category_id']);
	
	if(count($children) > 0){
		
		$this->spacer = '&nbsp;&nbsp;&nbsp;'.$this->spacer;

		foreach($children as $child) {			

			$filter_data = array('filter_category_id' => $child['category_id'], 'filter_sub_category' => true);

			$record = array(
				'category_id' => $child['category_id'],
				'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
				'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])					
			);				

			$record['children'] =  $this->getChildren($child,$data);
			
			$children_data[] = $record;
			
		}
	}

	return $children_data;
	
}
}
