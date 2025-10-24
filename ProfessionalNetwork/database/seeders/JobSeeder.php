<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\JobListing;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'company' => 'Google',
                'title' => 'Engenheiro de Software Sênior - Full Stack',
                'description' => 'Estamos procurando um Engenheiro de Software Sênior para se juntar à nossa equipe de desenvolvimento. Você trabalhará em projetos inovadores que impactam milhões de usuários globalmente, desenvolvendo soluções escaláveis e de alta performance.',
                'requirements' => '• 5+ anos de experiência em desenvolvimento full-stack\n• Proficiência em JavaScript, Python, Java ou Go\n• Experiência com frameworks modernos (React, Angular, Vue.js)\n• Conhecimento em arquitetura de microsserviços\n• Experiência com cloud computing (GCP, AWS, Azure)\n• Inglês fluente',
                'benefits' => '• Salário competitivo + equity\n• Plano de saúde premium\n• 30 dias de férias\n• Orçamento para desenvolvimento profissional\n• Trabalho híbrido\n• Refeições gratuitas\n• Ginástica laboral',
                'salary_min' => 15000,
                'salary_max' => 25000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Microsoft',
                'title' => 'Product Manager - Azure AI',
                'description' => 'Lidere o desenvolvimento de produtos de IA na plataforma Azure. Trabalhe com equipes multifuncionais para definir a estratégia de produto e entregar soluções inovadoras de inteligência artificial para empresas globais.',
                'requirements' => '• MBA ou experiência equivalente em gestão de produtos\n• 3+ anos em product management de produtos tech\n• Experiência com IA/ML e cloud computing\n• Habilidades analíticas e de liderança\n• Experiência com metodologias ágeis\n• Inglês fluente',
                'benefits' => '• Pacote de remuneração competitivo\n• Stock options\n• Plano de saúde e odontológico\n• Licença parental estendida\n• Programa de mentoria\n• Trabalho remoto flexível',
                'salary_min' => 18000,
                'salary_max' => 30000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Nubank',
                'title' => 'Desenvolvedor Backend - Kotlin/Java',
                'description' => 'Junte-se ao time que está revolucionando o sistema financeiro brasileiro! Desenvolva microsserviços robustos e escaláveis que processam milhões de transações diariamente, sempre com foco na melhor experiência do cliente.',
                'requirements' => '• 3+ anos de experiência com Kotlin ou Java\n• Experiência com Spring Boot e microsserviços\n• Conhecimento em bancos de dados relacionais e NoSQL\n• Experiência com Kafka, Redis, Docker\n• Conhecimento em práticas de DevOps\n• Paixão por fintech e inovação',
                'benefits' => '• Salário + PLR + equity\n• Plano de saúde Nubank\n• Auxílio home office\n• NuConta com benefícios exclusivos\n• Programa de educação continuada\n• Ambiente diverso e inclusivo',
                'salary_min' => 12000,
                'salary_max' => 20000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => true
            ],
            [
                'company' => 'iFood',
                'title' => 'Data Scientist - Machine Learning',
                'description' => 'Transforme dados em insights que impactam milhões de pedidos diários! Desenvolva algoritmos de ML para otimização de rotas, previsão de demanda e personalização da experiência do usuário na maior plataforma de delivery da América Latina.',
                'requirements' => '• Mestrado/PhD em áreas quantitativas ou experiência equivalente\n• 4+ anos de experiência em Data Science/ML\n• Proficiência em Python, R, SQL\n• Experiência com TensorFlow, PyTorch, Scikit-learn\n• Conhecimento em Big Data (Spark, Hadoop)\n• Experiência com A/B testing',
                'benefits' => '• Remuneração competitiva + bônus\n• Vale refeição iFood\n• Plano de saúde e dental\n• Gympass\n• Programa de desenvolvimento técnico\n• Trabalho híbrido\n• Ambiente pet-friendly',
                'salary_min' => 14000,
                'salary_max' => 22000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => false
            ],
            [
                'company' => 'Stone',
                'title' => 'Engenheiro DevOps - Cloud Infrastructure',
                'description' => 'Construa e mantenha a infraestrutura que suporta milhões de transações financeiras diárias. Trabalhe com tecnologias de ponta em cloud computing, automação e monitoramento para garantir alta disponibilidade e segurança.',
                'requirements' => '• 4+ anos de experiência em DevOps/SRE\n• Expertise em AWS, Kubernetes, Docker\n• Experiência com Terraform, Ansible, Jenkins\n• Conhecimento em monitoramento (Prometheus, Grafana)\n• Experiência com linguagens de script (Python, Bash)\n• Conhecimento em segurança de infraestrutura',
                'benefits' => '• Salário competitivo + participação nos lucros\n• Plano de saúde Stone\n• Auxílio educação e certificações\n• Maquininha Stone gratuita\n• Programa de bem-estar\n• Flexibilidade de horários',
                'salary_min' => 13000,
                'salary_max' => 21000,
                'location' => 'Rio de Janeiro, RJ',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Mercado Livre',
                'title' => 'Engenheiro de Software - Mobile',
                'description' => 'Desenvolva aplicativos móveis que conectam milhões de usuários na América Latina. Trabalhe com tecnologias nativas e híbridas para criar experiências excepcionais.',
                'requirements' => '• 3+ anos em desenvolvimento mobile (iOS/Android)\n• Experiência com Swift, Kotlin ou React Native\n• Conhecimento em arquiteturas MVVM, MVP\n• Experiência com APIs REST e GraphQL\n• Conhecimento em testes unitários\n• Inglês intermediário',
                'benefits' => '• Salário + bônus por performance\n• Plano de saúde premium\n• Desconto em compras no ML\n• Programa de desenvolvimento\n• Trabalho híbrido\n• Auxílio home office',
                'salary_min' => 11000,
                'salary_max' => 18000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => true
            ],
            [
                'company' => 'Uber',
                'title' => 'UX/UI Designer - Rider Experience',
                'description' => 'Projete experiências que impactam milhões de usuários diariamente. Trabalhe na interface do aplicativo do passageiro, criando soluções intuitivas e acessíveis.',
                'requirements' => '• 4+ anos de experiência em UX/UI Design\n• Portfólio sólido com casos de estudo\n• Proficiência em Figma, Sketch, Adobe XD\n• Experiência com design systems\n• Conhecimento em pesquisa de usuário\n• Inglês fluente',
                'benefits' => '• Pacote de remuneração competitivo\n• Créditos Uber e Uber Eats\n• Plano de saúde global\n• Programa de bem-estar mental\n• Flexibilidade total de trabalho\n• Licença parental estendida',
                'salary_min' => 12000,
                'salary_max' => 20000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Magazine Luiza',
                'title' => 'Analista de Marketing Digital',
                'description' => 'Lidere campanhas digitais que conectam nossa marca com milhões de clientes. Trabalhe com performance, branding e inovação no maior varejista digital do Brasil.',
                'requirements' => '• 2+ anos em marketing digital\n• Experiência com Google Ads, Facebook Ads\n• Conhecimento em Google Analytics, GTM\n• Experiência com e-mail marketing\n• Conhecimento em SEO/SEM\n• Graduação em Marketing ou áreas afins',
                'benefits' => '• Salário + PLR\n• Desconto em produtos Magalu\n• Plano de saúde e odontológico\n• Vale refeição e alimentação\n• Programa de desenvolvimento\n• Ambiente diverso e inclusivo',
                'salary_min' => 6000,
                'salary_max' => 10000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => false
            ],
            [
                'company' => 'PicPay',
                'title' => 'Desenvolvedor Frontend - React',
                'description' => 'Construa interfaces que simplificam a vida financeira de milhões de brasileiros. Trabalhe com React, TypeScript e as melhores práticas de desenvolvimento frontend.',
                'requirements' => '• 3+ anos de experiência com React\n• Proficiência em TypeScript, JavaScript ES6+\n• Experiência com Redux, Context API\n• Conhecimento em testes (Jest, Testing Library)\n• Experiência com Styled Components\n• Conhecimento em metodologias ágeis',
                'benefits' => '• Salário competitivo + equity\n• PicPay Card com benefícios\n• Plano de saúde PicPay\n• Auxílio educação\n• Trabalho remoto\n• Day off no aniversário',
                'salary_min' => 9000,
                'salary_max' => 15000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => true
            ],
            [
                'company' => 'Banco Inter',
                'title' => 'Especialista em Segurança da Informação',
                'description' => 'Proteja os dados e sistemas de milhões de clientes. Trabalhe com segurança cibernética, compliance e gestão de riscos em um dos bancos digitais que mais cresce no Brasil.',
                'requirements' => '• 5+ anos em segurança da informação\n• Certificações CISSP, CISM ou similares\n• Experiência com SIEM, SOC\n• Conhecimento em compliance (LGPD, PCI-DSS)\n• Experiência com testes de penetração\n• Graduação em TI ou áreas afins',
                'benefits' => '• Salário + participação nos resultados\n• Conta Inter com benefícios\n• Plano de saúde premium\n• Auxílio certificações\n• Trabalho híbrido\n• Programa de bem-estar',
                'salary_min' => 15000,
                'salary_max' => 25000,
                'location' => 'Belo Horizonte, MG',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Globo',
                'title' => 'Jornalista Digital - Esportes',
                'description' => 'Cubra os principais eventos esportivos do Brasil e do mundo. Trabalhe na redação digital do maior grupo de mídia do país, produzindo conteúdo para múltiplas plataformas.',
                'requirements' => '• Graduação em Jornalismo\n• 3+ anos de experiência em jornalismo esportivo\n• Experiência com redação digital\n• Conhecimento em SEO e redes sociais\n• Capacidade de trabalhar sob pressão\n• Paixão por esportes',
                'benefits' => '• Salário + PLR\n• Plano de saúde Globo\n• Acesso a eventos esportivos\n• Vale refeição\n• Programa de desenvolvimento\n• Ambiente criativo e colaborativo',
                'salary_min' => 8000,
                'salary_max' => 14000,
                'location' => 'Rio de Janeiro, RJ',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => false
            ],
            [
                'company' => 'Spotify',
                'title' => 'Data Engineer - Music Intelligence',
                'description' => 'Construa pipelines de dados que alimentam algoritmos de recomendação musical. Trabalhe com big data, machine learning e tecnologias de ponta para personalizar a experiência de milhões de usuários.',
                'requirements' => '• 4+ anos em engenharia de dados\n• Experiência com Python, Scala ou Java\n• Conhecimento em Spark, Kafka, Airflow\n• Experiência com AWS ou GCP\n• Conhecimento em bancos NoSQL\n• Inglês fluente',
                'benefits' => '• Salário + equity + bônus\n• Spotify Premium gratuito\n• Plano de saúde global\n• Auxílio bem-estar (R$ 1.000/mês)\n• Trabalho remoto global\n• 6 meses de licença parental',
                'salary_min' => 16000,
                'salary_max' => 28000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Netflix',
                'title' => 'Content Analyst - Brazilian Originals',
                'description' => 'Analise e desenvolva estratégias para conteúdo original brasileiro. Trabalhe com dados, tendências e insights para criar séries e filmes que encantam audiências globais.',
                'requirements' => '• MBA ou experiência equivalente\n• 3+ anos em análise de conteúdo/entretenimento\n• Conhecimento do mercado audiovisual brasileiro\n• Experiência com análise de dados\n• Habilidades analíticas avançadas\n• Inglês fluente',
                'benefits' => '• Salário + bônus anual\n• Netflix gratuito para família\n• Plano de saúde premium\n• Auxílio educação ilimitado\n• Trabalho remoto flexível\n• Cultura de liberdade e responsabilidade',
                'salary_min' => 18000,
                'salary_max' => 30000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'senior',
                'is_remote' => true
            ],
            [
                'company' => 'Rappi',
                'title' => 'Growth Hacker - User Acquisition',
                'description' => 'Acelere o crescimento de usuários da Rappi no Brasil. Trabalhe com marketing de performance, experimentação e análise de dados para otimizar funis de aquisição.',
                'requirements' => '• 2+ anos em growth hacking ou marketing digital\n• Experiência com Facebook Ads, Google Ads\n• Conhecimento em analytics e experimentação\n• Experiência com SQL e Python (diferencial)\n• Mentalidade data-driven\n• Inglês intermediário',
                'benefits' => '• Salário + equity\n• Créditos Rappi ilimitados\n• Plano de saúde\n• Auxílio transporte\n• Ambiente internacional\n• Oportunidades de crescimento rápido',
                'salary_min' => 8000,
                'salary_max' => 14000,
                'location' => 'São Paulo, SP',
                'type' => 'full-time',
                'level' => 'mid',
                'is_remote' => true
            ]
        ];

        foreach ($jobs as $jobData) {
            $company = Company::where('name', $jobData['company'])->first();
            
            if ($company) {
                JobListing::create([
                    'company_id' => $company->id,
                    'title' => $jobData['title'],
                    'description' => $jobData['description'],
                    'requirements' => $jobData['requirements'],
                    'benefits' => $jobData['benefits'],
                    'salary_min' => $jobData['salary_min'],
                    'salary_max' => $jobData['salary_max'],
                    'location' => $jobData['location'],
                    'type' => $jobData['type'],
                    'level' => $jobData['level'],
                    'is_remote' => $jobData['is_remote'],
                    'is_active' => true
                ]);
            }
        }
    }
}