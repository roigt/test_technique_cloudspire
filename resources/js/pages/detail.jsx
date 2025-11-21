import {
    Box,
    Button,
    ButtonGroup,
    Card,
    CardBody,
    CardFooter,
    CardHeader,
    Divider,
    Heading,
    Stack,
    StackDivider,
    Text,
    Image,
    Center,
    BreadcrumbItem,
    Breadcrumb,
    BreadcrumbLink,
} from '@chakra-ui/react';

export default function Detail({hotel}){
    return (

        <div>
            <div>
                <Breadcrumb fontWeight="medium" fontSize="md" h={100} backgroundColor={'blue.200'}>
                    <BreadcrumbItem>
                        <BreadcrumbLink href="/hotels">Home</BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        <BreadcrumbLink href="">Detail</BreadcrumbLink>
                    </BreadcrumbItem>
                </Breadcrumb>
            </div>
            <Center margin={20}>
                <Card maxW='sm'>
                    <CardBody>
                        <Image
                            src='https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80'
                            alt='Green double couch with wooden legs'
                            borderRadius='lg'
                        />
                        <Stack mt='6' spacing='3'>
                            <Heading size='md'>{hotel.name}</Heading>
                            <Text>
                                {hotel.description}
                            </Text>
                        </Stack>
                    </CardBody>
                </Card>
            </Center>

        </div>



    )
}
