<?php
/*
 * This file is part of the ideneal/emailoctopus library
 *
 * (c) Daniele Pedone <ideneal.ztl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ideneal\EmailOctopus\Tests\Serializer;

use Ideneal\EmailOctopus\Entity\MailingListField;
use Ideneal\EmailOctopus\Serializer\MailingListFieldSerializer;

/**
 * Class MailingListFieldSerializerTest
 *
 * @package Ideneal\EmailOctopus\Tests\Serializer
 */
class MailingListFieldSerializerTest extends ApiSerializerTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->json = [
            [
                'tag'      => 'EmailAddress',
                'type'     => 'TEXT',
                'label'    => 'Email address',
                'fallback' => null,
            ],
            [
                'tag'      => 'FirstName',
                'type'     => 'TEXT',
                'label'    => 'First Name',
                'fallback' => null,
            ],
            [
                'tag'      => 'LastName',
                'type'     => 'TEXT',
                'label'    => 'Last name',
                'fallback' => null,
            ],
        ];
    }

    /**
     * Tests mailing test field serialization.
     */
    public function testSerialization()
    {
        $field = new MailingListField();
        $field
            ->setLabel('Email')
            ->setTag('EmailAddress')
            ->setType(MailingListField::TEXT)
        ;

        $json = MailingListFieldSerializer::serialize($field);

        $this->assertIsArray($json);
        $this->assertArrayHasKey('label', $json);
        $this->assertArrayHasKey('tag', $json);
        $this->assertArrayHasKey('type', $json);
        $this->assertArrayHasKey('fallback', $json);
        $this->assertEquals('Email', $json['label']);
        $this->assertEquals('EmailAddress', $json['tag']);
        $this->assertEquals('TEXT', $json['type']);
    }

    /**
     * Tests a mailing list field json object deserialization.
     */
    public function testJsonObjectDeserialization()
    {
        $field = MailingListFieldSerializer::deserializeSingle($this->json[0]);

        $this->assertInstanceOf(MailingListField::class, $field);
        $this->assertEquals('EmailAddress', $field->getTag());
        $this->assertEquals(MailingListField::TEXT, $field->getType());
    }

    /**
     * Tests a mailing list fields json array deserialization.
     */
    public function testJsonArrayDeserialization()
    {
        $fields = MailingListFieldSerializer::deserializeMultiple($this->json);

        $this->assertIsArray($fields);
        $this->assertContainsOnlyInstancesOf(MailingListField::class, $fields);
        $this->assertCount(3, $fields);
    }
}
