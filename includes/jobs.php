<?php
declare(strict_types=1);

/**
 * Open roles, shared by the jobs page and the application endpoint so the
 * two can't drift apart. To add or remove a role, edit this array only —
 * the listings, the form dropdown, and server-side validation all read it.
 *
 * Set 'open' => false to take a role down without deleting its details.
 */
function jobs_list(): array
{
    return [
        [
            'id' => 'ai-engineer',
            'title' => 'AI Engineer',
            'icon' => 'code',
            'type' => 'Full-time',
            'location' => 'Jeddah, Saudi Arabia / Remote',
            'department' => 'Engineering',
            'open' => true,
            'summary' => 'Build and deploy AI-powered tools and automations that accelerate product growth for our clients and internal team.',
            'responsibilities' => [
                'Design and develop AI-powered features and integrations',
                'Build automation pipelines using LLMs (OpenAI, Claude, Gemini)',
                'Integrate AI tools into marketing and growth workflows',
                'Develop internal tools to automate reporting and data analysis',
                'Work closely with the growth team to identify AI opportunities',
                'Maintain and improve existing AI systems',
            ],
            'requirements' => [
                '2+ years experience in software engineering',
                'Hands-on experience with OpenAI, Anthropic, or similar APIs',
                'Proficiency in Python and/or TypeScript',
                'Experience with REST APIs and backend development',
                'Familiarity with prompt engineering and RAG systems',
                'Strong problem-solving and communication skills',
            ],
            'nice' => [
                'Experience with LangChain, LlamaIndex, or similar frameworks',
                'Knowledge of vector databases (Pinecone, Weaviate, etc.)',
                'Background in marketing tech or growth tools',
            ],
        ],
        [
            'id' => 'ai-expert',
            'title' => 'AI Expert',
            'icon' => 'brain',
            'type' => 'Full-time',
            'location' => 'Jeddah, Saudi Arabia / Remote',
            'department' => 'Strategy & Growth',
            'open' => true,
            'summary' => 'Lead AI strategy for clients and the agency — identifying opportunities, guiding implementations, and educating the team on best practices.',
            'responsibilities' => [
                'Define and lead AI strategy for client campaigns and internal workflows',
                'Advise clients on AI adoption in their marketing and product operations',
                'Evaluate and onboard new AI tools across the agency',
                'Train and upskill internal team members on AI capabilities',
                'Stay current with the latest AI models, tools, and trends',
                'Collaborate with the engineering team on AI product development',
            ],
            'requirements' => [
                '3+ years experience working with AI/ML systems',
                'Deep understanding of generative AI and large language models',
                'Experience applying AI to marketing, growth, or business operations',
                'Strong communication skills — able to explain AI concepts simply',
                'Track record of delivering AI-driven results',
                'Strategic thinker with a hands-on mindset',
            ],
            'nice' => [
                'Experience in digital marketing or growth agencies',
                'Published work, talks, or courses on AI',
                'Arabic language skills (a plus for Saudi clients)',
            ],
        ],
    ];
}

/** Only the roles currently accepting applications. */
function jobs_open(): array
{
    return array_values(array_filter(jobs_list(), fn(array $j): bool => $j['open']));
}

/** Human-readable title for a role id, or null if it isn't an open role. */
function job_title(string $id): ?string
{
    foreach (jobs_open() as $job) {
        if ($job['id'] === $id) return $job['title'];
    }
    return null;
}
