pipeline {
    agent any

    environment {
        COMPOSE_PROJECT_NAME = "task_manager_ci"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/aqsaIrfan002/task_manager_ci-root.git'
            }
        }

        stage('Build Docker Images') {
            steps {
                script {
                    sh 'docker-compose -p $COMPOSE_PROJECT_NAME -f docker-compose.ci.yml build'
                }
            }
        }

        stage('Run Containers') {
            steps {
                script {
                    sh 'docker-compose -p $COMPOSE_PROJECT_NAME -f docker-compose.ci.yml up -d'
                }
            }
        }
    }

    post {
        always {
            echo 'Cleaning up...'
            sh 'docker-compose -p $COMPOSE_PROJECT_NAME -f docker-compose.ci.yml down || true'
        }
    }
}
