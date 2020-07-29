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
				$cat_data = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);

				$filter_data = array(
					'filter_category_id' => $category['category_id'],
					'start'              => 0,
					'limit'              => 20,
				);
	
				$results = $this->model_catalog_product->getProducts($filter_data);
	
				foreach ($results as $result) {
	
					$cat_data['products'][] = array(
						'product_id'  => $result['product_id'],
						//'thumb'       => $image,
						'name'        => $result['name'],
						//'description' => utf8_substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..',
						//'price'       => $price,
						//'special'     => $special,
						//'tax'         => $tax,
						//'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
						//'rating'      => $result['rating'],
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
					);

				}

				if( isset($cat_data['products']) && count($cat_data['products']) > 0){
					$data['categories'][] = $cat_data;
				}

			}
		}

		$data['categories'] = array_slice($data['categories'],0,4,true);
		
		$this->load->model('service/repair');
		$this->load->model('service/repair_rate');

		$repair_categories = $this->model_service_repair->getCategories();		

		foreach($repair_categories as $category){

			$cat_data = array(
				'name' => $category['name'],
				'href' => $this->url->link('service/repair/category', 'path='.$category['category_id'])
			);

			$filter_data = array(
				'filter_category_id' => $category['category_id'],
				'filter_repair' => TRUE,			
			);

			$results = $this->model_catalog_product->getProducts($filter_data);
	
			foreach ($results as $result) {
				
				$rates = $this->model_service_repair_rate->getProductRates($result['product_id']);			

				if(count($rates) > 0){

					$cat_data['products'][] = array(
						'product_id'  => $result['product_id'],
						'name'        => $result['name'],
						'href'        => $this->url->link('service/repair/product', 'product_id=' . $result['product_id'])
					);
				}

			}
			if( isset($cat_data['products']) && count($cat_data['products']) > 0){
				$data['repair_categories'][] = $cat_data;
			}
		}

		

		$this->load->model('service/sell');
		$this->load->model('service/sell_rate');

		$sell_categories = $this->model_service_sell->getCategories();		

		foreach($sell_categories as $category){

			$cat_data = array(
				'name' => $category['name'],
				'href' => $this->url->link('service/repair/category', 'path='.$category['category_id'])
			);

			$filter_data = array(
				'filter_category_id' => $category['category_id'],
				'filter_repair' => TRUE,			
			);

			$results = $this->model_catalog_product->getProducts($filter_data);
	
			foreach ($results as $result) {
				
				$rates = $this->model_service_sell_rate->getProductRates($result['product_id']);			

				if(count($rates) > 0){

					$cat_data['products'][] = array(
						'product_id'  => $result['product_id'],
						'name'        => $result['name'],
						'href'        => $this->url->link('service/sell/product', 'product_id=' . $result['product_id'])
					);
				}

			}
			if( isset($cat_data['products']) && count($cat_data['products']) > 0){
				$data['sell_categories'][] = $cat_data;
			}
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
