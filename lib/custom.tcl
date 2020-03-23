# customized section
# for use with the backend
# apnscp operations

# hello is a simple example to
# get you started on the structure
# this can be invoked through:
# echo CheckLocalServer($gDomainName,"hello");
proc hello {host args} {
    return "Hello World, from host: $host!\nArg list: [join $args]"
}