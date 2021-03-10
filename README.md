Assessement API
=====================
Symfony 4 bundle for sending notifications

Requirements
-----------------------------------
* Php 8.0
***
Installation
-----------------------------------
1. Clone the repository

2. Install requirements :
```bash
php composer.phar install
```

3. Run local web server:
```bash
php -S 127.0.0.1:8000 -t public
```

4. See the Open API documentation:
url: https://localhost:8000/api

5. Use an API testing tool to access the API (e.g. Postman)

***
Set up
-----------------------------------
1. File config/services.yaml
```yaml

## API SET UP

#Default question data extractor
#    App\DataExtractor\QuestionEntityDataExtractorInterface: '@App\DataExtractor\QuestionJsonEntityExtractor'
App\DataExtractor\QuestionEntityDataExtractorInterface: '@App\DataExtractor\QuestionCsvEntityExtractor'

#Default question data source
#    App\DataSource\QuestionsDataSourceInterface: '@App\DataSource\QuestionJsonDataSource'
App\DataSource\QuestionsDataSourceInterface: '@App\DataSource\QuestionCsvDataSource'

#Default question data destination
#    App\DataSource\QuestionDataDestinationInterface: '@App\DataDestination\QuestionJsonDataSource'
App\DataSource\QuestionDataDestinationInterface: '@App\DataDestination\QuestionCsvDataDestination'

'App\Serializer\QuestionSerializer':
  decorates: 'api_platform.serializer.normalizer.item'

#Default questions data provider
'App\DataProvider\QuestionFileCollectionDataProvider':
  tags: [ { name: 'api_platform.collection_data_provider', priority: 1 } ]
  # Autoconfiguration must be disabled to set a custom priority
  autoconfigure: false
```
If you wish to use json file instead of csv to save data:
uncomment:
```yaml
#    App\DataExtractor\QuestionEntityDataExtractorInterface: '@App\DataExtractor\QuestionJsonEntityExtractor'
#    App\DataSource\QuestionsDataSourceInterface: '@App\DataSource\QuestionJsonDataSource'
#    App\DataSource\QuestionDataDestinationInterface: '@App\DataDestination\QuestionJsonDataSource'
```
comment:

```yaml
App\DataExtractor\QuestionEntityDataExtractorInterface: '@App\DataExtractor\QuestionCsvEntityExtractor'
App\DataSource\QuestionsDataSourceInterface: '@App\DataSource\QuestionCsvDataSource'
App\DataSource\QuestionDataDestinationInterface: '@App\DataDestination\QuestionCsvDataDestination' 
```
