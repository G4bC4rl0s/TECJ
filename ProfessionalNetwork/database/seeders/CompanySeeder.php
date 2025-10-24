<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'name' => 'Google',
                'email' => 'recrutamento@google.com',
                'description' => 'Organizamos as informações do mundo e as tornamos universalmente acessíveis e úteis. Junte-se a nós para resolver os maiores desafios da tecnologia.',
                'website' => 'https://careers.google.com',
                'industry' => 'Tecnologia',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 1998
            ],
            [
                'name' => 'Microsoft',
                'email' => 'careers@microsoft.com',
                'description' => 'Capacitamos cada pessoa e organização do planeta a conquistar mais. Venha fazer parte da nossa missão de transformar o mundo através da tecnologia.',
                'website' => 'https://careers.microsoft.com',
                'industry' => 'Tecnologia',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 1975
            ],
            [
                'name' => 'Nubank',
                'email' => 'vagas@nubank.com.br',
                'description' => 'Somos uma empresa de tecnologia financeira que luta contra a complexidade para empoderar pessoas. Reinventamos serviços financeiros no Brasil e no mundo.',
                'website' => 'https://nubank.com.br/carreiras',
                'industry' => 'Financeiro',
                'size' => '201-500 funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2013
            ],
            [
                'name' => 'iFood',
                'email' => 'trabalheconosco@ifood.com.br',
                'description' => 'Conectamos pessoas, comida e propósito. Somos a maior foodtech da América Latina, revolucionando a forma como as pessoas se relacionam com a comida.',
                'website' => 'https://carreiras.ifood.com.br',
                'industry' => 'Tecnologia',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2011
            ],
            [
                'name' => 'Stone',
                'email' => 'gente@stone.com.br',
                'description' => 'Somos uma empresa de tecnologia que oferece soluções financeiras completas. Nossa missão é descomplicar o empreendedorismo no Brasil.',
                'website' => 'https://careers.stone.com.br',
                'industry' => 'Financeiro',
                'size' => '201-500 funcionários',
                'location' => 'Rio de Janeiro, RJ',
                'founded_year' => 2012
            ],
            [
                'name' => 'Mercado Livre',
                'email' => 'jobs@mercadolivre.com',
                'description' => 'Democratizamos o comércio e os pagamentos para impactar a vida das pessoas na América Latina. Somos a maior plataforma de e-commerce da região.',
                'website' => 'https://careers.mercadolibre.com',
                'industry' => 'E-commerce',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 1999
            ],
            [
                'name' => 'Uber',
                'email' => 'careers@uber.com',
                'description' => 'Movemos o mundo. Conectamos pessoas e oportunidades através de tecnologia, criando possibilidades para todos.',
                'website' => 'https://uber.com/careers',
                'industry' => 'Tecnologia',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2009
            ],
            [
                'name' => 'Magazine Luiza',
                'email' => 'vagas@magazineluiza.com.br',
                'description' => 'Somos uma empresa de tecnologia que conecta pessoas e transforma vidas através do varejo. Inovação e diversidade são nossos pilares.',
                'website' => 'https://carreiras.magazineluiza.com.br',
                'industry' => 'Varejo',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 1957
            ],
            [
                'name' => 'PicPay',
                'email' => 'trabalheconosco@picpay.com',
                'description' => 'Democratizamos serviços financeiros através de tecnologia. Somos uma fintech que simplifica a vida financeira dos brasileiros.',
                'website' => 'https://picpay.com/carreiras',
                'industry' => 'Financeiro',
                'size' => '201-500 funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2012
            ],
            [
                'name' => 'Banco Inter',
                'email' => 'rh@bancointer.com.br',
                'description' => 'Somos um banco digital completo que oferece soluções financeiras inovadoras. Transformamos a experiência bancária no Brasil.',
                'website' => 'https://bancointer.com.br/carreiras',
                'industry' => 'Financeiro',
                'size' => '201-500 funcionários',
                'location' => 'Belo Horizonte, MG',
                'founded_year' => 1994
            ],
            [
                'name' => 'Globo',
                'email' => 'vagas@globo.com',
                'description' => 'Somos uma empresa de mídia e entretenimento que conecta, informa e diverte milhões de brasileiros todos os dias.',
                'website' => 'https://redeglobo.globo.com/rh',
                'industry' => 'Mídia',
                'size' => '500+ funcionários',
                'location' => 'Rio de Janeiro, RJ',
                'founded_year' => 1925
            ],
            [
                'name' => 'Spotify',
                'email' => 'jobs@spotify.com',
                'description' => 'Desbloqueamos o potencial da criatividade humana dando a milhões de artistas criativos a oportunidade de viver de sua arte.',
                'website' => 'https://spotify.com/careers',
                'industry' => 'Tecnologia',
                'size' => '201-500 funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2006
            ],
            [
                'name' => 'Netflix',
                'email' => 'careers@netflix.com',
                'description' => 'Entretenemos o mundo. Somos a principal plataforma de streaming, criando experiências incríveis para nossos membros globalmente.',
                'website' => 'https://netflix.com/careers',
                'industry' => 'Entretenimento',
                'size' => '500+ funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 1997
            ],
            [
                'name' => 'Rappi',
                'email' => 'jobs@rappi.com',
                'description' => 'Somos uma super app que conecta usuários, estabelecimentos e entregadores, oferecendo conveniência na palma da mão.',
                'website' => 'https://rappi.com/careers',
                'industry' => 'Tecnologia',
                'size' => '201-500 funcionários',
                'location' => 'São Paulo, SP',
                'founded_year' => 2015
            ]
        ];

        foreach ($companies as $companyData) {
            // Criar usuário para a empresa
            $user = User::create([
                'name' => $companyData['name'],
                'email' => $companyData['email'],
                'password' => Hash::make('password123'),
                'is_company' => true
            ]);

            // Criar empresa
            Company::create([
                'user_id' => $user->id,
                'name' => $companyData['name'],
                'description' => $companyData['description'],
                'website' => $companyData['website'],
                'industry' => $companyData['industry'],
                'size' => $companyData['size'],
                'location' => $companyData['location'],
                'founded_year' => $companyData['founded_year']
            ]);
        }
    }
}