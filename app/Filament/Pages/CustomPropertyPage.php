<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class CustomPropertyPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.custom-property-page';

    public $properties;

    public function mount(){
        $this->properties = DB::connection('mysql2')->select("
            select a.id propiedad_id
            ,a.post_title as propiedad_nombre
            ,ifnull(upper(t3.bank_name),'SIN BANCO') nombre_banco
            ,case
            when trim(fc.meta_value) = '' then 'N/A'
            when fc.meta_value is null then 'N/A'
            else fc.meta_value
            end numero_finca
            ,a.guid link_propiedad
            from dbgoejmewmxmr4.zZVOtBumposts a
            left join dbgoejmewmxmr4.zZVOtBumpostmeta b on b.post_id = a.id and b.meta_key = 'estate_attr_price_7'
            left join dbgoejmewmxmr4.zZVOtBumpostmeta c on c.post_id = a.id and c.meta_key = 'estate_featured' and c.meta_value is not null and c.meta_value != ''
            left join dbgoejmewmxmr4.zZVOtBumpostmeta d on d.post_id = a.id and d.meta_key = 'estate_attr_bedrooms' and d.meta_value is not null and d.meta_value != '' and d.meta_value > 0
            left join dbgoejmewmxmr4.zZVOtBumpostmeta e on e.post_id = a.id and e.meta_key = 'estate_attr_bathrooms' and e.meta_value is not null and e.meta_value != '' and e.meta_value > 0
            left join dbgoejmewmxmr4.zZVOtBumusers  f on f.id = a.post_author
            left join dbgoejmewmxmr4.zZVOtBumpostmeta g on g.post_id = a.id and g.meta_key = 'estate_attr_property-size'
            left join dbgoejmewmxmr4.zZVOtBumpostmeta z on z.post_id = a.id and z.meta_key = 'estate_attr_price'
            left join dbgoejmewmxmr4.zZVOtBumpostmeta fc on fc.post_id = a.id and fc.meta_key = 'estate_attr_attribute_25'
            left join (
            select aa.object_id, aa.term_taxonomy_id, bb.term_id, bb.taxonomy, bb.description, cc.name, cc.slug
            from dbgoejmewmxmr4.zZVOtBumterm_relationships aa
            left join dbgoejmewmxmr4.zZVOtBumterm_taxonomy bb on bb.term_taxonomy_id = aa.term_taxonomy_id
            left join dbgoejmewmxmr4.zZVOtBumterms cc on cc.term_id = bb.term_id
            ) term1 on term1.object_id = a.id and term1.taxonomy = 'ciudad'
            left join (
            select aa.object_id as id, group_concat(cc.name) address
            from dbgoejmewmxmr4.zZVOtBumterm_relationships aa
            inner join dbgoejmewmxmr4.zZVOtBumterm_taxonomy bb on bb.term_taxonomy_id = aa.term_taxonomy_id
            inner join dbgoejmewmxmr4.zZVOtBumterms cc on cc.term_id = bb.term_id
            where bb.taxonomy in ('canton', 'direccion')
            group by aa.object_id
            ) term2 on term2.id = a.id
            left join (
            select aa.object_id as id, group_concat(cc.name) bank_name
            from dbgoejmewmxmr4.zZVOtBumterm_relationships aa
            inner join dbgoejmewmxmr4.zZVOtBumterm_taxonomy bb on bb.term_taxonomy_id = aa.term_taxonomy_id
            inner join dbgoejmewmxmr4.zZVOtBumterms cc on cc.term_id = bb.term_id
            where bb.taxonomy in ('banco')
            group by aa.object_id
            ) t3 on t3.id = a.id
            where a.post_type = 'estate'
        ");
    }
}
