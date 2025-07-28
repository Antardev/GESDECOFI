<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubDomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subDomains = [
            ['name' => 'Missions spécifiques', 'domain_name' => 'Missions comptables et spécifiques', 'domain_id' => 1],
            ['name' => 'Comptabilité, Audit du secteur agricole et coopératif', 'domain_name' => 'Missions comptables et spécifiques', 'domain_id' => 1],
            ['name' => 'Consolidation en IFRS', 'domain_name' => 'Missions comptables et spécifiques', 'domain_id' => 1],
            ['name' => 'Comptabilité et Audit du secteur de la prévoyance Sociale', 'domain_name' => 'Missions comptables et spécifiques', 'domain_id' => 1],
            ['name' => 'Les collectivités locales, aspect juridique, financier, comptable et d’audit', 'domain_name' => 'Missions comptables et spécifiques', 'domain_id' => 1],
            ['name' => 'Commissariat aux comptes', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Audit Fiscal', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Détection des fraudes', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Mission d’examen limité', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Révision des comptes', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Commissariat aux comptes des entreprises en difficultés', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Aspect juridiques-commissariat aux comptes-Gouvernance des sociétés', 'domain_name' => 'Missions de Commissariat aux comptes', 'domain_id' => 2],
            ['name' => 'Contrôle Qualité', 'domain_name' => 'Management du cabinet', 'domain_id' => 3],
            ['name' => 'Organisation d’un cabinet : Manuel de procédure', 'domain_name' => 'Management du cabinet', 'domain_id' => 3],
            ['name' => 'Diagnostic financier des PME', 'domain_name' => 'Management du cabinet', 'domain_id' => 3],
            ['name' => 'Optimisation fiscale, contrôle fiscale et contentieux', 'domain_name' => 'Missions d\'assistance juridique et fiscale', 'domain_id' => 4],
            ['name' => 'Audit des Systèmes Financiers Décentralisés (SFD)', 'domain_name' => 'Audit des institutions de micro finance', 'domain_id' => 5],
            ['name' => 'Comptabilité et finance publique : Principes et textes juridiques nationaux, communautaires et internationaux', 'domain_name' => 'Audit des institutions de micro finance', 'domain_id' => 5],
            ['name' => 'Audit institutionnel, Organisationnel, Opérationnel et Audit de gestion d’un organisme public', 'domain_name' => 'Gestion financière et audit des projets', 'domain_id' => 6],
            ['name' => 'Comptabilité et Audit du secteur public', 'domain_name' => 'Gestion financière et audit des projets', 'domain_id' => 6],
            ['name' => 'Contrôle des comptes des associations et des organisations à But Non Lucratif', 'domain_name' => 'Gestion financière et audit des projets', 'domain_id' => 6],
            ['name' => 'Monter un Business Plan', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Audit d’acquisition', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Accompagnement des très Petites entreprises et secteur informel', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Procédures collectives OHADA pour les entreprises en difficultés', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Mission de médiation et de conciliation', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Conseil en gestion : Management stratégique, tableaux de bord, planification financière et prévision de trésorerie', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Accompagnement des investisseurs', 'domain_name' => 'Missions de conseil en gestion', 'domain_id' => 7],
            ['name' => 'Normes de comportement et de déontologie professionnelle', 'domain_name' => 'Pratiques professionnelles', 'domain_id' => 8],
            ['name' => 'La profession dans l’UEMOA : historique, organisation et perspectives', 'domain_name' => 'Pratiques professionnelles', 'domain_id' => 8],
            ['name' => 'Opération de blanchissement', 'domain_name' => 'Autres missions', 'domain_id' => 9],
            ['name' => 'La rédaction de la notice et du mémoire', 'domain_name' => 'Préparation du mémoire', 'domain_id' => 10],
            ['name' => 'Evaluer le système d’information d’une PME', 'domain_name' => 'Missions informatique et d\'organisation', 'domain_id' => 11],
            ['name' => 'Excel avancé', 'domain_name' => 'Missions informatique et d\'organisation', 'domain_id' => 11],
            ['name' => 'Les logiciels d’audit', 'domain_name' => 'Missions informatique et d\'organisation', 'domain_id' => 11],
        ];
        
        $a = 1;
        
        foreach ($subDomains as $subDomain) {
            DB::table('sub_domains')->insert([
                'id' => $a,
                'domain_id' => $subDomain['domain_id'], 
                'name' => $subDomain['name'],
                'domain_name' => $subDomain['domain_name'],
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $a++;
        }
    }
}