# Software-Quality-Attributes-Implementation

A software product must have certain quality attributes to meet certain non-functional requirements that measures the quality of software product.

Quality Attribute Availability is achieved by implementing Active Redundancy i.e. a copy of original service is maintained. 
Whenever one of the virtual machine or service is down, request is redirected to another redundant service.
A continuous GET request is made to the service to checkf it is returning response.
In case response in not returned, a further ping is made to the machine to check if it is up and
requests are directed to another redundant service on different machine, thus achieving high availability.

HIGH PERFORMANCE is achieved by implementimg load balncing based on type of request made by the user.

A detailed readme regarding implementation can be found in individul folders.
