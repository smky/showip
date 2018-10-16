node {
    def app

    stage('Clone repository') {
        /* Let's make sure we have the repository cloned to our workspace */

        checkout scm
    }

    stage('Build image') {
        /* This builds the actual image; synonymous to
         * docker build on the command line */

        app = docker.build("kamas/showip")
    }

    stage('Test image') {
        /* Ideally, we would run a test framework against our image.
         * For this example, we're using a Volkswagen-type approach ;-) */

        app.inside {
            sh 'echo "Tests passed"'
        }
    }

    stage('Push image') {
        /* Finally, we'll push the image with two tags:
         * First, the incremental build number from Jenkins
         * Second, the 'latest' tag.
         * Pushing multiple tags is cheap, as all the layers are reused. */
        docker.withRegistry('https://registry.hub.docker.com', 'docker-hub-credentials') {
            app.push("jenkins-build-v${env.BUILD_NUMBER}")
            app.push("latest")
        }
    }
        stage('Deploy Cattle') {
        /* Deploy to production: */
            
            withCredentials([
                string(credentialsId: 'CATTLE_ACCESS_KEY', variable: 'CATTLE_ACCESS_KEY'),
                string(credentialsId: 'CATTLE_SECRET_KEY', variable: 'CATTLE_SECRET_KEY'),
                string(credentialsId: 'CATTLE_URL', variable: 'CATTLE_URL')
            
            ]) {

                    sh 'docker run --rm -i \
                -e CATTLE_ACCESS_KEY="$CATTLE_ACCESS_KEY" \
                -e CATTLE_SECRET_KEY="$CATTLE_SECRET_KEY" \
                -e CATTLE_URL="$CATTLE_URL" \
                etlweather/gaucho upgrade 1s31  \
                --imageUuid "docker:kamas/showip:jenkins-build-v$BUILD_NUMBER" \
                --batch_size 3 --start_first \
                --auto_complete --timeout 600 \
                /'
            }
        }
}
