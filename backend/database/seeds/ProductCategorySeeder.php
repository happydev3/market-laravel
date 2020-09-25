<?php

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $category = new ProductCategory();
        $category->name = "Generic";
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Abbigliamento';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Scarpe e Borse';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Alimentari e Cura della Casa';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Arredamento';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Farmacia e Parafarmacia';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();


        $category = new ProductCategory();
        $category->name = 'Abbigliamento';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Cancelleria e Ufficio';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Casa e Cucina';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Energia e Gas';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Animali';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Elettronica';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Fai da Te';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Film e TV';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Giardinaggio';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Giochi e Giocattoli';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Gioielli e Bigiotteria';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Informatica';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();


        $category = new ProductCategory();
        $category->name = 'Libri';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category = new ProductCategory();
        $category->name = 'Prima Infanzia';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Servizi di Ristorazione';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Strumenti Musicali';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

        $category =  new ProductCategory();
        $category->name = 'Telefonia';
        $category->slug = $this->generateCategorySlug($category->name);
        $category->lang = "it";
        $category->save();

    }

    private function generateCategorySlug($categoryName){
        return strtolower(str_replace(" ","-",$categoryName));
    }
}
