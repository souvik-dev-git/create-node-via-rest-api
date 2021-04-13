Rest API to create node in Drupal 8

Below are the steps to run the api in Drupal 8 architecture

1. Enable below 4 core modules under “WEB SERVICES” category
HAL
HTTP Basic Authentication
RESTful Web Services
Serialization

![dependending_modules](https://user-images.githubusercontent.com/82392042/114506551-97ea5b80-9c4f-11eb-8c12-b5f72601fe9b.png)


2. Additionally a contrib module “REST UI” has been installed to change permission & settings of the resource plugin through an interface


Module URL: https://www.drupal.org/project/restui

3. Enable the custom module “Create Rest Api” in Drupal modules panel (<site_url>/admin/modules)

![custom_module](https://user-images.githubusercontent.com/82392042/114506628-b2bcd000-9c4f-11eb-989f-210fe2d69607.png)


Note: While installing the module, it will automatically create two fields Tags (Taxonomy Reference) & Publish Date (Plain text). So no need to create these fields manually. You just need to enable those two fields from admin panel (<site_url>/admin/structure/types/manage/page/form-display)

![activate_fields](https://user-images.githubusercontent.com/82392042/114507087-45f60580-9c50-11eb-8afa-c5cc9dcea810.png)


4. Enable the resource plugin from REST UI (<site_url>/admin/config/services/rest)

![rest_resource](https://user-images.githubusercontent.com/82392042/114507166-5efeb680-9c50-11eb-8743-c9e3a3ce8087.png)

5. Save the configuration of the resource plugin

![rest_resource_settings](https://user-images.githubusercontent.com/82392042/114507194-6625c480-9c50-11eb-9588-e571c5594977.png)


6. I have used “POSTMAN” Rest Client to run the api. Below are the configuration for the Rest Client

# API URL: <site_name>/create-api-node

Set the method to “POST”

![post_method](https://user-images.githubusercontent.com/82392042/114507398-b13fd780-9c50-11eb-9ca1-873544831072.png)


Set parameter:
Below parameter should be added:
_format : json

![reqd_params](https://user-images.githubusercontent.com/82392042/114507682-15fb3200-9c51-11eb-9364-1fbfbd87c56e.png)


Set authorization:
As “basic_auth” has been set for Authentication Providers in REST UI, we have selected the “Basic Auth” option and will enter the drupal username & password of the user for which the content will be created.

![reqd_authentication](https://user-images.githubusercontent.com/82392042/114507627-fd8b1780-9c50-11eb-8d88-43183b37b24a.png)

Note: Make sure the logged in user has permission to create content for the specific content-type

Set Headers:
The following headers have to be added for this call
Content-type: application/json

![reqd_headers](https://user-images.githubusercontent.com/82392042/114507739-30351000-9c51-11eb-9893-820d744e0d30.png)


Set Body:
Now need to set below fields for the node:
Content Type (Basic Page, machine name: page)
Title
Body
Term Reference Id
Publish Date timestamp

![reqd_body](https://user-images.githubusercontent.com/82392042/114507863-5955a080-9c51-11eb-9851-23386df37084.png)

API Response after node has been created successfully:

![api_response](https://user-images.githubusercontent.com/82392042/114507909-696d8000-9c51-11eb-891d-c039f8a61aed.png)


To make sure go to ‘<site_url>/admin/content’ and check if the node has been created

![new_content_1](https://user-images.githubusercontent.com/82392042/114508008-87d37b80-9c51-11eb-82d1-03b610090358.png)

![new_content_2](https://user-images.githubusercontent.com/82392042/114508019-8ace6c00-9c51-11eb-82f3-42a9dec02340.png)

As seen from the attached screenshot the node has been created with “Title”, “Body”, “Term Reference”, “Publish Date” fields
