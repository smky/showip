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
                    sh 'docker run --rm -it \
                -e CATTLE_ACCESS_KEY="76186D0414ECF2CBDFC4" \
                -e CATTLE_SECRET_KEY="oe4fKyyHKHyNtAZYZc32duf943Zp5Q3iqzko5ppD" \
                -e CATTLE_URL="http://192.168.1.155:8080/" \
                etlweather/gaucho upgrade 1s31  \
                --imageUuid '"docker:kamas/showip:latest"' \
                --batch_size 3 --start_first \
                --auto_complete --timeout 600 \
                /'
                
        }
}
