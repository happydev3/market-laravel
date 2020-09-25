<?php

use Illuminate\Database\Seeder;
use App\Models\StoreCategory;


class StoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeCat = new StoreCategory();
        $storeCat->name = 'Generic';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Abbigliamento';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Scarpe e Borse';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Alimentari e Cura della Casa';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Arredamento';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Auto e Moto';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Bellezza e Salute';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Farmacia e Parafarmacia';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Banca e Assicurazione';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Cancelleria e Ufficio';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Casa e Cucina';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Carburanti';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Energia e Gas';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Animali';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Elettronica';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Grande Dist. Organizzata';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Fai da Te';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Film e TV';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Giardinaggio';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Giochi e Giocattoli';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Gioielli e Bigiotteria';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Illuminazione';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();


        $storeCat = new StoreCategory();
        $storeCat->name = 'Informatica';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Libri';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Ottica';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Prima Infanzia';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Servizi di Ristorazione';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Strumenti Musicali';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Telefonia';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

        $storeCat = new StoreCategory();
        $storeCat->name = 'Trasporti';
        $storeCat->slug = $this->generateCategorySlug($storeCat->name);
        $storeCat->lang = "it";
        $storeCat->save();

    }

    private function generateCategorySlug($categoryName){
        return strtolower(str_replace(" ","-",$categoryName));
    }
}
