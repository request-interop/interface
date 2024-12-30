# PSR-7 vs RequestInterop

(Some portions copied, with light editing, from <https://paul-m-jones.com/post/2017/01/05/psr-7-vs-the-serverrequestresponse-rfc/>.)

## PSR-7

PSR-7 was born to answer the question, "How can we model HTTP messages in PHP for sending a request, and getting back a response?" That is, how can we standardize the model of an HTTP request message for sending, and the model of the returned the HTTP response, when using PHP as an HTTP client?

The entrance vote passed in Jan 2014 after about a year of pre-work, with Michael "Guzzle" Dowling as lead (<https://groups.google.com/d/topic/php-fig/H1Lr7FYxj94/discussion>). You can see the original draft at <https://github.com/php-fig/fig-standards/pull/244/files>.

What you’ll find in the draft is one pair of request/response interfaces, descended from a message interface, with stream as message body, and no URI specification. These were designed primarily as client interfaces; all the referenced projects in the draft were client-side. (As a side note, they were mutable. Dowling said, "Having mutable and immutable messages would add a significant amount of complexity to a HTTP message PSR and would not reflect what is currently being used by a majority of PHP projects.")

After 8 months, Dowling stepped down in August 2014, citing a lack of time and motivation. He also said: "I don’t think there’s one way to represent HTTP messages, clients, or servers in PHP." https://groups.google.com/forum/#!topic/php-fig/XwFcqSmqzGk

Shortly thereafter, in September 2014, with encouragement from many (including myself), MAtthew Weier O'Phinney of Zend Framework [takes over PSR-7](https://groups.google.com/d/topic/php-fig/CTPRa2XP8po/discussion). We learn that he has "Sencha Connect" and middleware on the brain:

> The reason I wanted to port Connect is this: an application consists of middleware. Each middleware is a callback that accepts a request, response, and a callback called "next" (which is optional, actually):
>
> ```php
> function (request, response, next)
> ```
>
> ...
>
> I know from Michael Dowling that the original intent for PSR-7 was to define HTTP messages that could then be used in HTTP clients. I am here to argue that they are even more important when considering server-side applications.

At this point, we see that PSR-7 has been expanded to answer a second question: "How can we model HTTP messages for receiving a request, and sending back a response?" This is in addition to the original goal, but idea is the same: building a standard model of HTTP messages.

(For full disclosure, note that [I became a sponsor on PSR-7 in December 2014](https://groups.google.com/d/topic/php-fig/Y3a4hcRN610/discussion), along with Beau Simensen as the coordinator.)

It is during MWOP’s tenure, [before the successful acceptance vote](https://groups.google.com/d/topic/php-fig/0baLqR6Rvcg/discussion) in May 2015, that we see the PSR-7 interfaces expand in number, and become "immutable" (with one intentional exception, and other unintentional exceptions).

So we can see that the purpose of PSR-7 is to model [2 sets of HTTP messages using 7 interfaces](http://www.php-fig.org/psr/psr-7/): one set for when PHP sends a request and receives a response, and an addition set for when PHP receives a request and sends a response.

## RequestInterop

RequestInterop starts out by asking a different question. It is not concerned with modeling HTTP messages, whether sending or receiving them.

Instead, it asks: "How can we take the request-related superglobals in PHP and encapsulate them in objects, to make them at least a little more object-oriented?" Becuase RequestInterop begins with a different question, it leads to a different answer: a _Request_ interface that exposes only properties, mimicking PHP’s superglobals.

## Other Differences

There are some additional differences not included above, all specific to the PSR-7 _ServerRequestInterface_.

### Immutability

RequestInterop requires that implementations advertised as readonly or immutable be **deeply** readonly or immutable. _ServerRequestInterface_ makes no such demand; instead, it explicitly allows mutability in various ways, most notably the _StreamInterface_ but also the attributes and parsed body.

### Attributes and Application State

_ServerRequestInterface_ does not only model the incoming HTTP request message. It also models some portion of the application context via the "attributes" elements. As a result, the "attributes" become a dumping-ground for anything and everything that might need to be carried along in the middleware chain for application-specific context. Further, they are intended to be mutable, breaking the promised immutability of implementations.

(Cf. [ServerRequestInterface::getAttributes()](https://github.com/php-fig/http-message/blob/master/src/ServerRequestInterface.php#L202-L206)).

RequestInterop does not provide a space for application-specific context. It limits itself to the PHP superglobals and values calculated from them alone.

### Parsed Body vs `$input`

Whereas _ServerRequestInterface_ comes down on one side regarding the ["parsed body"](https://www.php-fig.org/psr/psr-7/meta/#why-parsed-body-in-the-serverrequestinterface) type and structure, RequestInterop comes down on the opposite side.

The _ServerRequestInterface_ solution allows an array **or object** to be the "parsed body". Further, any object at all may be part of that "parsed body". This has the benefit of flexibility, in that anything at all may be parsed out the request body. The drawbacks are that it is ambiguous, difficult to typehint, and makes it easy to break expectations of the immutability otherwise promised by the interface.

RequestInterop, on the other hand, restricts its corresponding `$input` property to an array whose values are nulls, scalars, or (recursively) arrays of nulls and scalars. This eliminates any possibility of mutable elements contained in an otherwise readonly or immutable object, at the cost of disallowing objects and resources in the `$input`. This also provides consistency and comparability with the PHP superglobals.
