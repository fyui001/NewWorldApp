pipeline {
  agent any
  stages {
    stage('test') {
      steps {
        sh 'apt update'
        sh 'apt-get install -y libpng-dev libjpeg-dev libxrender1 libxext6 libfontconfig1'
        sh 'apt-get install php8.1'
      }
    }

  }
}